<?php
$config = array(
			'user-student' => array(
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'required|valid_email|is_unique[users.email]'
				),
				array(
					'field' => 'username',
					'label' => 'Username',
					'rules' => 'required|alpha_numeric|min_length[3]|max_length[50]|is_unique[users.username]'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required|min_length[8]'
				),
				array(
					'field' => 'student_id',
					'label' => 'Student Id',
					'rules' => 'required|integer'
					)
			),
			'student-registration' => array(
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'required|valid_email|is_unique[users.email]'
				),
				array(
					'field' => 'username',
					'label' => 'Username',
					'rules' => 'required|alpha_numeric|min_length[3]|max_length[50]|is_unique[users.username]'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required|min_length[8]|matches[password_confirmation]'
				),
				array(
					'field' => 'password_confirmation',
					'label' => 'Password Confirmation',
					'rules' => 'required|matches[password]'
				),
				array(
					'field' => 'student_id',
					'label' => 'Student Id',
					'rules' => 'required|integer'
					),
				array(
					'field' => 'major_id',
					'label' => 'Major',
					'rules' => 'required|integer'
					),
				array(
					'field' => 'phone_number',
					'label' => 'Phone Number',
					'rules' => 'required|max_length[13]|integer'
					)
			),
			'user-trainer' => array(
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'required|valid_email|is_unique[users.email]'
				),
				array(
					'field' => 'username',
					'label' => 'Username',
					'rules' => 'required|alpha_numeric|min_length[3]|max_length[50]|is_unique[users.username]'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required|min_length[8]'
				)
			),
			'profile' => array(
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'required|valid_email|is_unique[users.email]'
					),
				array(
					'field' => 'username',
					'label' => 'Username',
					'rules' => 'required|alpha_numeric|min_length[3]|max_length[50]|is_unique[users.username]'
					),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required|min_length[8]'
					),
				array(
					'field' => 'password_confirmation',
					'label' => 'Password Confirmation',
					'rules' => 'required|matches[password]'
					)

				),
			'training' => array(
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
					'field' => 'quota',
					'label' => 'Quota',
					'rules' => 'required|numeric')
				)
		);