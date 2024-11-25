<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
'employee_code'=>fake()->name(),
'employee_name'=>fake()->name(),
'employee_phone'=>fake()->phoneNumber(),
'employee_email'=>fake()->email(),
'passtypes_id'=>fake()->randomDigit(),
'employee_nric'=>fake()->postcode(),
'employee_mobile'=>fake()->phoneNumber(),
'employee_tel'=>fake()->phoneNumber(),
'employee_birthdate'=>fake()->dateTime($max = 'now', $timezone = null),
'employee_joindate'=>fake()->dateTime($max = 'now', $timezone = null),
'employee_confirmationdate'=>fake()->dateTime($max = 'now', $timezone = null),
'employee_prdate'=>fake()->dateTime($max = 'now', $timezone = null),
'employee_resigndate'=>fake()->dateTime($max = 'now', $timezone = null),
'employee_resignreason'=>fake()->word(),
'employee_numberofchildren'=>fake()->randomDigit(),
'users_id'=>fake()->randomDigit(),
'manager_users_id'=>fake()->randomDigit(),
'team_leader_users_id'=>fake()->randomDigit(),
'employee_shrc'=>fake()->word(),
'employee_defination'=>fake()->text(),
'leave_aprv1_users_id'=>fake()->randomDigit(),
'leave_aprv2_users_id'=>fake()->randomDigit(),
'leave_aprv3_users_id'=>fake()->randomDigit(),
'claims_aprv1_users_id'=>fake()->randomDigit(),
'claims_aprv2_id'=>fake()->randomDigit(),
'claims_aprv3_users_id'=>fake()->randomDigit(),
'is_payroll_enable'=>0,
'is_cpf_enable'=>0,
'employee_isovertime'=>0,
'paymodes_id'=>0,
'employee_bank'=>fake()->name(),
'employee_bank_acc_no'=>fake()->creditCardNumber(),
'employee_bank_acc_title'=>fake()->name(),
'employee_street'=>fake()->streetAddress(),
'employee_unit_number'=>fake()->randomDigit(),
'employee_postal_code'=>fake()->postcode(),
'employee_street2'=>fake()->streetAddress(),
'employee_unit_number2'=>fake()->randomDigit(),
'employee_postal_code2'=>fake()->postcode(),
'employee_emr_contact'=>fake()->phonenumber(),
'employee_emr_relation'=>fake()->name(),
'employee_emr_phone1'=>fake()->name(),
'employee_emr_phone2'=>fake()->name(),
'employee_emr_address'=>fake()->name(),
'employee_emr_remarks'=>fake()->name(),
'departments_id'=>fake()->randomDigit(),
'designations_id'=>fake()->randomDigit(),
'employee_work_time_start'=>fake()->dateTime($max = 'now', $timezone = null),
'employee_work_time_end'=>fake()->dateTime($max = 'now', $timezone = null),
'races_id'=>fake()->randomDigit(),
'religions_id'=>fake()->randomDigit(),
'dbsexes_id'=>fake()->randomDigit(),
'marital_statuses_id'=>fake()->randomDigit(),
'clients_id'=>fake()->randomDigit(),
'employee_status'=>1,
'employee_isDeleted'=>0,
'created_by'=>fake()->randomDigit(),
'modify_by'=>fake()->randomDigit(),

        ];
    }
}
