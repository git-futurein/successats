<script>
            $(document).ready(function() {
                let auth_role = '{{ $auth->roles_id }}';
                let auth = '{{ $auth->id }}';

                $('#managerSelect').change(function() {
                    let managerId = $(this).val();
                    get_team_lead(managerId);
                });

                $('#teamLeaderSelect').change(function() {
                    let teamLeaderId = $(this).val();
                    get_consultant(teamLeaderId)
                });

                if (auth_role == 1) {
                    $('#managerSelect').trigger('change');
                } else if (auth_role == 4) {
                    get_team_lead(auth);
                } else if (auth_role == 11) {
                    get_consultant(auth);
                }

                function get_team_lead(managerId)
                {
                    if (managerId) {
                        $.ajax({
                            type: 'GET',
                            url: '/ATS/get/teamleader/' + managerId,
                            success: function(data) {
                                $('#teamLeaderSelect').empty();
                                let candidateTeamLeaderId = '{{ $candidate->team_leader_id }}';
                                let option = $('<option>', {
                                    value: '',
                                    text: 'Choose One',
                                });
                                $('#teamLeaderSelect').append(option);

                                $.each(data, function(key, value) {
                                    var option = $('<option>', {
                                        value: value.id,
                                        text: value.employee_name
                                    });
                                    if (value.id == candidateTeamLeaderId) {
                                        option.prop('selected', true);
                                    }
                                    $('#teamLeaderSelect').append(option);
                                });

                                $('#teamLeaderSelect').trigger('change');
                            }
                        });
                    } else {
                        $('#teamLeaderSelect').empty();
                    }
                }

                function get_consultant(teamLeaderId)
                {
                    if (teamLeaderId) {
                        $.ajax({
                            type: 'GET',
                            url: '/ATS/get/consultant/' + teamLeaderId,
                            success: function(data) {
                                $('#consultantSelect').empty();
                                let consultant_id = '{{ $candidate->consultant_id }}';

                                let option = $('<option>', {
                                    value: '',
                                    text: 'Choose One',
                                });
                                $('#consultantSelect').append(option);
                                $.each(data, function(key, value) {
                                    option = $('<option>', {
                                        value: value.id,
                                        text: value.employee_name
                                    });
                                    if (value.id == consultant_id) {
                                        option.prop('selected', true);
                                    }
                                    $('#consultantSelect').append(option);
                                });
                            }
                        });
                    } else {
                        $('#consultantSelect').empty();
                    }
                }
            });
        </script>
