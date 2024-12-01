<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendenceParent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\FileHelper;

class AttendanceController extends Controller
{

    private function processAttachments($uploadedFiles)
    {
        $attachments = [];

        if ($uploadedFiles) {
            foreach ($uploadedFiles as $uploadedFile) {
                $attachments[] = FileHelper::uploadFile($uploadedFile);
            }
            return json_encode($attachments);
        }

        return null;
    }

    public function mystore(Request $request)
    {
        // return $request;
        // try {
        return  $request->candidate_id;
        $attP = new AttendenceParent;
        $attP->candidate_id = $request->candidate_id;
        $attP->company_id = $request->company_id ?? 0;
        $attP->invoice_no = $request->invoice_no ?? 0;
        $attP->month_year = $request->month_year;
        $attP->save();

        $data = $request->group;
        foreach ($data as $day => $group) {
            $leave_attachment = isset($request->file('group')[$day]['leave_attachment'])
                                ? $this->processAttachments($request->file('group')[$day]['leave_attachment'])
                                : $group['old_leave_attachment'] ?? '';

            $claim_attachment = isset($request->file('group')[$day]['claim_attachment'])
                                ? $this->processAttachments($request->file('group')[$day]['claim_attachment'])
                                    : $group['old_claim_attachment'];
            $date = Carbon::createFromFormat('d-m-Y', $group['date']);
            $formattedDate = $date->format('Y-m-d');

            $att = new Attendance();
            $att->parent_id = $attP->id;
            $att->date = $formattedDate;
            $att->day = $group['day'];
            $att->in_time = $group['in_time'];
            $att->out_time = $group['out_time'];
            $att->next_day = $group['next_day'] ?? 0;
            $att->lunch_hour = $group['lunch_hour'] ? $group['lunch_hour'] : "";
            $att->total_hour_min = $group['total_hour_min'];
            $att->normal_hour_min = $group['normal_hour_min'];
            $att->ot_hour_min = $group['ot_hour_min'];
            $att->ot_calculation = $group['ot_calculation'];
            $att->ot_edit = $group['ot_edit'] ?? 0;
            $att->work = isset($group['work']) ? 1 : 0;
            $att->ph = $group['ph'] ?? 0;
            $att->ph_pay = $group['ph_pay'] ?? 0;
            $att->remark = $group['remark'];
            $att->type_of_leave = $group['type_of_leave'];
            $att->leave_day = $group['leave_day'];
            $att->leave_attachment = $leave_attachment;
            $att->claim_attachment = $claim_attachment;
            $att->type_of_reimbursement = isset($group['type_of_reimbursement']) ? $group['type_of_reimbursement'] : '';
            $att->amount_of_reimbursement = isset($group['amount_of_reimbursement']) ? $group['amount_of_reimbursement'] : 0.00;

            $att->save();
        }
        return redirect()->route('attendence.index');
        //  } catch (\Exception $e) {

        //      \Log::error('Error creating attendance: ' . $e->getMessage());


        //      return redirect()->route('attendence.create')->with('error', 'Failed to add attendance. Please try again.');
        //  }
    }

    public function get_attendence(AttendenceParent $parent)
    {
        $attendances = Attendance::where('parent_id', $parent->id)->get();

        return $attendances;
    }

    public function get_single_attendence(Attendance $attendance)
    {
        return $attendance;
    }
}
