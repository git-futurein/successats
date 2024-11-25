<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAministrator = Role::create(['name' => 'Aministrator']);


        // Permission List as array
        $permissions = [

            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'admin.dashboard',
                ]
            ],
            [
                'group_name' => 'attendence',
                'permissions' => [
                    'attendence.index',
                    'attendence.store',
                    'attendence.create',
                    'attendence.show',
                    'attendence.update',
                    'attendence.destroy',
                ]
            ],
            [
                'group_name' => 'bank',
                'permissions' => [
                    'bank.index',
                    'bank.store',
                    'bank.create',
                    'bank.show',
                    'bank.update',
                    'bank.destroy',
                ]
            ],
            [
                'group_name' => 'candidate',
                'permissions' => [
                    'candidate.index',
                    'candidate.store',
                    'candidate.create',
                    'candidate.family',
                    'candidate.family.delete',
                    'candidate.file.delete',
                    'candidate.file.upload',
                    'candidate.followup',
                    'candidate.followup.delete',
                    'candidate.payroll',
                    'candidate.remark',
                    'candidate.remark.delete',
                    'candidate.resume',
                    'candidate.resume.delete',
                    'candidate.working.hour',
                    'candidate.show',
                    'candidate.update',
                    'candidate.destroy',
                    'candidate.edit',
                    'temporary.data.delete',
                    'extract.info',
                    'upload.files',
                    'delete.uploaded.data',
                    'candidate.payroll.delete',
                ]
            ],
            [
                'group_name' => 'client-term',
                'permissions' => [
                    'client-term.index',
                    'client-term.store',
                    'client-term.create',
                    'client-term.show',
                    'client-term.update',
                    'client-term.destroy',
                    'client-term.edit',

                ]
            ],
            [
                'group_name' => 'clients',
                'permissions' => [
                    'clients.index',
                    'clients.store',
                    'clients.show',
                    'clients.create',
                    'clients.update',
                    'clients.destroy',
                    'clients.edit',
                    'client.file.delete',
                    'client.file.upload',
                    'client.followup',
                    'client.followup.delete',
                ]
            ],
            [
                'group_name' => 'company',
                'permissions' => [
                    'company.index',
                    'company.store',
                    'company.show',
                    'company.create',
                    'company.update',
                    'company.destroy',
                    'company.edit',
                ]
            ],
            [
                'group_name' => 'pass-type',
                'permissions' => [
                    'pass-type.index',
                    'pass-type.store',
                    'pass-type.show',
                    'pass-type.create',
                    'pass-type.update',
                    'pass-type.destroy',
                    'pass-type.edit',
                ]
            ],
            [
                'group_name' => 'menu',
                'permissions' => [
                    'menu.index',
                    'menu.store',
                    'menu.create',
                    'menu.show',
                    'menu.update',
                    'menu.destroy',
                    'menu.edit',
                ]
            ],
            [
                'group_name' => 'department',
                'permissions' => [
                    'department.index',
                    'department.store',
                    'department.create',
                    'department.show',
                    'department.update',
                    'department.destroy',
                    'department.edit',
                ]
            ],
            [
                'group_name' => 'designation',
                'permissions' => [
                    'designation.index',
                    'designation.store',
                    'designation.create',
                    'designation.show',
                    'designation.update',
                    'designation.destroy',
                    'designation.edit',
                ]
            ],
            [
                'group_name' => 'employee',
                'permissions' => [
                    'employee.index',
                    'employee.store',
                    'employee.create',
                    'employee.show',
                    'employee.update',
                    'employee.destroy',
                    'employee.edit',
                    'employee.salary.info.post',
                ]
            ],
            [
                'group_name' => 'file-type',
                'permissions' => [
                    'file-type.index',
                    'file-type.store',
                    'file-type.create',
                    'file-type.show',
                    'file-type.update',
                    'file-type.destroy',
                    'file-type.edit',
                ]
            ],
            [
                'group_name' => 'giro',
                'permissions' => [
                    'giro.index',
                    'giro.store',
                    'giro.create',
                    'giro.show',
                    'giro.update',
                    'giro.destroy',
                    'giro.edit',
                ]
            ],
            [
                'group_name' => 'import',
                'permissions' => [
                    'import.index',
                    'import.store',
                    'import.create',
                    'import.update',
                    'import.show',
                    'import.edit',
                ]
            ],
            [
                'group_name' => 'industry-type',
                'permissions' => [
                    'industry-type.index',
                    'industry-type.store',
                    'industry-type.create',
                    'industry-type.show',
                    'industry-type.update',
                    'industry-type.destroy',
                    'industry-type.edit',
                ]
            ],
            [
                'group_name' => 'job',
                'permissions' => [
                    'job.index',
                    'job.store',
                    'job.create',
                    'job.show',
                    'job.update',
                    'job.destroy',
                    'job.edit',
                ]
            ],
            [
                'group_name' => 'job-category',
                'permissions' => [
                    'job-category.index',
                    'job-category.store',
                    'job-category.create',
                    'job-category.show',
                    'job-category.update',
                    'job-category.destroy',
                    'job-category.edit',
                ]
            ],
            [
                'group_name' => 'job-application',
                'permissions' => [
                    'job-application.index',
                    'job-application.store',
                    'job-application.create',
                    'job-application.show',
                    'job-application.update',
                    'job-application.destroy',
                    'job-application.edit',
                ]
            ],
            [
                'group_name' => 'job-type',
                'permissions' => [
                    'job-type.index',
                    'job-type.store',
                    'job-type.create',
                    'job-type.show',
                    'job-type.update',
                    'job-type.destroy',
                    'job-type.edit',
                ]
            ],
            [
                'group_name' => 'leave',
                'permissions' => [
                    'leave.index',
                    'leave.store',
                    'leave.create',
                    'leave.show',
                    'leave.update',
                    'leave.destroy',
                    'leave.edit',
                ]
            ],
            [
                'group_name' => 'leave-type',
                'permissions' => [
                    'leave-type.index',
                    'leave-type.store',
                    'leave-type.create',
                    'leave-type.show',
                    'leave-type.update',
                    'leave-type.destroy',
                    'leave-type.edit',
                ]
            ],
            [
                'group_name' => 'marital-status',
                'permissions' => [
                    'marital-status.index',
                    'marital-status.store',
                    'marital-status.create',
                    'marital-status.show',
                    'marital-status.update',
                    'marital-status.destroy',
                    'marital-status.edit',
                ]
            ],
            [
                'group_name' => 'nationality',
                'permissions' => [
                    'nationality.index',
                    'nationality.store',
                    'nationality.create',
                    'nationality.show',
                    'nationality.update',
                    'nationality.destroy',
                    'nationality.edit',
                ]
            ],
            [
                'group_name' => 'religion',
                'permissions' => [
                    'religion.index',
                    'religion.store',
                    'religion.create',
                    'religion.show',
                    'religion.update',
                    'religion.destroy',
                    'religion.edit',
                ]
            ],
            [
                'group_name' => 'remarks-type',
                'permissions' => [
                    'remarks-type.index',
                    'remarks-type.store',
                    'remarks-type.create',
                    'remarks-type.show',
                    'remarks-type.update',
                    'remarks-type.destroy',
                    'remarks-type.edit',
                ]
            ],
            [
                'group_name' => 'roles',
                'permissions' => [
                    'roles.index',
                    'roles.store',
                    'roles.create',
                    'roles.show',
                    'roles.update',
                    'roles.destroy',
                    'roles.edit',
                ]
            ],
            [
                'group_name' => 'tnc',
                'permissions' => [
                    'tnc.index',
                    'tnc.store',
                    'tnc.create',
                    'tnc.show',
                    'tnc.update',
                    'tnc.destroy',
                    'tnc.edit',
                ]
            ],
            [
                'group_name' => 'users',
                'permissions' => [
                    'users.index',
                    'users.store',
                    'users.create',
                    'users.show',
                    'users.update',
                    'users.destroy',
                    'users.edit',
                ]
            ],
            [
                'group_name' => 'time-sheet',
                'permissions' => [
                    'time-sheet.index',
                    'time-sheet.store',
                    'time-sheet.create',
                    'time-sheet.show',
                    'time-sheet.update',
                    'time-sheet.destroy',
                    'time-sheet.edit',
                ]
            ],
        ];

        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
                $roleAministrator->givePermissionTo($permission);
                $permission->assignRole($roleAministrator);
            }
        }
    }
}
