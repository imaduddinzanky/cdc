<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

class Training extends Base{

 	public $table = "trainings";
 	protected $upload_path = ['banner' => './public/assets/upload/trainings_banners/'];

 	protected $fillable = array('title', 'banner', 'description', 'start_date', 'end_date');
 	protected $acceptNestedAttributes = array('training_materials' => ['file_name']);
 	protected $expected_files = array('banner' => 'required');
 	protected $upload_config = array();
 	protected $appends = ['status', 'total_participants', 'banner_url'];

    protected $sluggable = array('from' => 'title', 'to' => 'slug');

 	protected $rules = array(
				array(
					'field' => 'title',
					'label' => 'Title',
					'rules' => 'required|min_length[3]|is_unique[trainings.title]'
					),
				array(
					'field' => 'end_date',
					'label' => 'End date',
					'rules' => 'required|date_greater_than[start_date]'
					),
				array(
					'field' => 'start_date',
					'label' => 'Start date',
					'rules' => 'required')
				);

 	public function __construct(array $attributes = array())
 	{
 		parent::__construct($attributes);
 		$this->load('users','training_materials');
 		$this->upload_config = array(
 				'banner' => array(
 					'upload_path' => $this->upload_path['banner'],
					'allowed_types' => 'jpg|png|jpeg',
					'max_size' => 1024*2,
					'encrypt_name' => true
 					)
				);
 	}
 	public function training_materials()
 	{
 		return $this->hasMany('TrainingMaterial');
 	}

 	public function users()
 	{
 		return $this->belongsToMany('User', 'users_trainings')->withPivot('state', 'participate');
 	}

 	public function scopeFilter($res, $search)
	{
		if (!empty($search))
		{
			$query = array();
			array_push($query, 'Lower(title) like "%'.strtolower($search).'%"');
			$res = $res->whereRaw(implode(' OR ', $query));
		}
		return $res;
	}

 	public function participants()
    {
    	return $this->users_type('student');
    }

    public function trainers()
    {
    	return $this->users_type('trainer');
    }

    public function users_type($type)
    {
       return $this->users()->leftJoin('users_groups', 'users.id', '=', 'users_groups.user_id')
		  	  ->leftJoin('groups', 'groups.id', '=', 'users_groups.group_id')->where('groups.name', '=', $type)->get();
    }

    public function current_trainers_select()
    {
    	return array_map(function($t){
    			return $t->id;
    			}, $this->trainers()->all());
    }

 	public function save_a_training($data)
 	{
 		if ($this->store($data))
 		{
 			$this->save_trainers( array_key_exists('trainer_ids', $data) ? $data['trainer_ids'] : [] );
 			return true;
 		}
 	}

 	protected function save_trainers($trainer_ids=array())
 	{
 		$this->users()->sync($trainer_ids);
 	}

 	public function getStatusAttribute($value)
 	{
 		$today = strtotime(date("Y-m-d"));
 		$start = strtotime($this->start_date);
 		$end = strtotime($this->end_date);
 		$label = 'label-success';
 		if ($today < $start)
 		{
 			$label = "label-warning";
 			$value = 'Up coming';
 		}
 		elseif ($today >= $start && $today <= $end) {
 			$label = 'label-royal';
 			$value = 'On going';
 		}
 		else{
 			$value = 'Completed';
 		}
 		return "<span class='label ".$label."'>".$value."</span>";

 	}

 	public function getTotalParticipantsAttribute($value)
 	{
 		return $this->participants()->count();

 	}

 	public function getBannerUrlAttribute($value)
 	{
 		return soft_uploaded_file_url('trainings_banners/'.$this->banner);
 	}


}