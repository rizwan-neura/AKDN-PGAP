<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PGAP Workflow Notification</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">

    <h2 style="color: #159c49;">PGAP Workflow Notification</h2>

    <p>Dear Team,</p>

    @switch($action)
        @case('submit')
            <p>ACFP has submitted this project phase to Global AFP for review.</p>
            @break

        @case('send-back')
            <p>Global AFP has returned this project phase to ACFP for corrections.</p>
            @break

        @case('submit-to-csa')
            <p>Global AFP has submitted this project phase to CSA for review.</p>
            @break

        @case('send-back-to-global-afp')
            <p>CSA has returned this project phase to Global AFP for further action.</p>
            @break

        @case('reviewed')
            <p>CSA has marked this project phase as Reviewed.</p>
            @break
    @endswitch

    <table cellpadding="8" cellspacing="0" border="1"
        style="border-collapse: collapse; border-color: #ddd;">
        <tr>
            <td><strong>Project</strong></td>
            <td>{{ $projectName }}</td>
        </tr>
        <tr>
            <td><strong>Review Phase</strong></td>
            <td>{{ ucfirst($phase) }}</td>
        </tr>
        <tr>
            <td><strong>Action Performed By</strong></td>
            <td>{{ $actorName }}</td>
        </tr>
        <tr>
            <td><strong>Action</strong></td>
            <td>{{ $actionLabel ?? $action }}</td>
        </tr>
        <tr>
            <td><strong>Current Status</strong></td>
            <td>{{ $status }}</td>
        </tr>

        @if (filled($comments))
            <tr>
                <td><strong>Review Comments</strong></td>
                <td>{{ $comments }}</td>
            </tr>
        @endif
    </table>

    @if ($projectUrl)
        <p>
            <a href="{{ $projectUrl }}"
                style="display: inline-block; padding: 10px 16px;
                background: #159c49; color: #fff;
                text-decoration: none; border-radius: 4px;">
                Open Project in PGAP
            </a>
        </p>
    @endif

    <p>Please sign in to PGAP to review the project and take any required action.</p>

    <p>
        Regards,<br>
        <strong>PGAP System</strong>
    </p>

</body>
</html>