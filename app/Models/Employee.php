<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_code',
        'employee_name',
        'father_spouse_name',
        'gender',
        'marital_status',
        'dob',
        'personal_mobile',
        'official_mobile',
        'personal_email',
        'official_email',
        'relationship1',
        'relationship2',
        'nationality',
        'nationality_status',
        'permanent_address',
        'permanent_area_id',
        'permanent_city_id',
        'permanent_state_id',
        'permanent_country_id',
        'permanent_pincode',
        'comm_address',
        'comm_area_id',
        'comm_city_id',
        'comm_state_id',
        'comm_country_id',
        'comm_pincode',
        'mobile1',
        'mobile2',
        'email1',
        'email2',
        'prev_company_exp_yrs',
        'prev_company_name',
        'prev_company_ref_by',
        'account_name',
        'account_number',
        'bank_name',
        'branch_name',
        'ifsc_code',
        'profile_img',
        'department_id',
        'designation_id',
        'reporting_to',
        'role_id',
        'package',
        'date_of_join',
        'company_mail_id',
        'company_mobile_no',
        'originals_given_by',
        'originals_verified_by',
        'authorised_by',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'comm_area_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'comm_state_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'comm_city_id', 'id');
    }

    public function desingation()
    {
        return $this->belongsTo(Designation::class);
    }
}
