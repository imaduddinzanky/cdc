<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

class Training extends Base{

 	public $table = "trainings";
 	protected $upload_path = ['banner' => './public/assets/upload/trainings_banners/'];

 	protected $fillable = array('title', 'banner', 'description', 'start_date', 'end_date', 'start_hour', 'end_hour', 'quota');
 	protected $acceptNestedAttributes = array('training_materials' => ['file_name'], 'photos' => ['file_name']);
 	protected $expected_files = array('banner' => 'required');
 	protected $appends = ['status', 'total_participants', 'banner_url', 'valid_training_to_apply', 'quota_status'];

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
					'rules' => 'required'),
        array(
          'field' => 'start_hour',
          'label' => 'Start hour',
          'rules' => 'required|time24'
          ),
        array(
          'field' => 'end_hour',
          'label' => "End hour",
          'rules' => 'required|time24|time_greater_than[start_hour]'
          ),
				array(
					'field' => 'quota',
					'label' => 'Quota',
					'rules' => 'required|numeric'
          ),
        array(
          'field' => 'cdc_head_officer',
          'label' => 'CDC Head Officer',
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

 	public function photos()
 	{
 		return $this->morphMany('Photo', 'imageable');
 	}

 	public function comments()
 	{
 		return $this->hasMany('Comment');
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
    	return $this->users_type('student', 'users.first_name');
    }

    public function trainers()
    {
    	return $this->users_type('trainer');
    }

    public function users_type($type, $order = 'id')
    {
       return $this->users()->leftJoin('users_groups', 'users.id', '=', 'users_groups.user_id')
		  	  ->leftJoin('groups', 'groups.id', '=', 'users_groups.group_id')->where('groups.name', '=', $type)
          ->orderBy($order)->get();
    }

    public function confirmed_participants()
    {
      return $this->users()->wherePivot('participate', true)->get();
    }

    public function confirmed_participant($user)
    {
      return !$this->users()->where('users.id', $user->id)->wherePivot('participate', true)->get()->isEmpty();
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
 		$today = carbon_format();
 		$start = carbon_format($this->start_date);
 		$end = carbon_format($this->end_date);
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

  public function status()
  {
    $today = carbon_format();
    $start = carbon_format($this->start_date);
    $end = carbon_format($this->end_date);
    if ($today < $start)
    {
      $value = 'Up coming';
    }
    elseif ($today >= $start && $today <= $end) {
      $value = 'On going';
    }
    else{
      $value = 'Completed';
    }
    return $value;
  }

 	public function getTotalParticipantsAttribute($value)
 	{
 		return $this->participants()->count();

 	}

 	public function getBannerUrlAttribute($value)
 	{
 		return soft_uploaded_file_url('trainings_banners/'.$this->banner);
 	}

 	public function list_of_attendances($attendances=array())
 	{
 		foreach ($this->participants() as $participant) {
			if ($participant->pivot->participate)
			{
				array_push($attendances, $participant);
			}
		}
		return $attendances;
 	}

 	public function getValidTrainingToApplyAttribute($val)
 	{
 		$start_date = carbon_format($this->start_date);
 		$max = $start_date->copy()->subDays(2);
 		return (carbon_format() <= $max) && $this->quota_status;
 	}

 	public function getQuotaStatusAttribute()
 	{
 		$participants = 0;
 		foreach ($this->trainers() as $participant) {
 			if (is_null($participant->pivot->participate) || $participant->pivot->participate)
 			{
 				$participants++;
 			}
 		}
 		return $this->quota >= $participants;
 	}

 	public function delete_unconfirmed_participants()
 	{
 		if (carbon_format($this->start_date)->isToday())
 		{
 			foreach ($this->participants() as $participant) {
 				if (is_null($participant->pivot->participate))
				{
					$this->users()->updateExistingPivot($participant->id, array('state' => 'canceled', 'participate' => false));
				}
 			}
 		}
 	}

 	public function applyable($user)
 	{
 		if ($this->valid_training_to_apply)
 		{
 			if (is_null($this->users()->where('users.id', '=', $user->id)->first()))
 			{
 				return true;
 			}
 		}
 		return false;
 	}

 	public function confirmable($user=null)
 	{
 		if (!is_null($this->pivot))
 		{
 			if (is_null($this->pivot->participate)){return true;}
 		}else
 		{
 			if (!is_null($user))
 			{
 				if (!is_null($this->users()->wherePivot('participate', null)->first())){return true;}
 			}
 		}
 		return false;
 	}

 	public function apply($user)
 	{
 		try{
 			$this->users()->attach([$user->id => ['state' => 'up coming', 'participate' => null]]);
 		}catch(Exception $e)
 		{
 			$this->set_error_validation(array('apply' => $e->getMessage()));
 			return false;
 		}
 		return true;
 	}

 	public function confirm($user)
 	{
 		try{
 			$this->users()->updateExistingPivot($user->id, array('participate' => true));
 		}catch(Exception $e){
 			$this->set_error_validation(array('confirm' => $e->getMessage()));
 			return false;
 		}
 		return true;
 	}

  public function certifiable($user=null)
  {
    if (is_null($user))
    {
      return true;
      if ($this->status == 'Completed') {return true;}
    }else{
      return $this->confirmed_participant($user);
    }
  }

}