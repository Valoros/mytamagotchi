<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="margin:0;padding:20px;background:#f4f6f9;font-family:Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center">

<table width="420" cellpadding="0" cellspacing="0" 
       style="background:#ffffff;border-radius:16px;padding:30px;">

<tr>
<td align="center">
    <h2 style="margin-top:0;">🐾 {{ $pet->name }}</h2>
</td>
</tr>

<tr><td>

<!-- Progress Block -->
@php
    function bar($value, $color) {
        return '
        <div style="background:#e5e7eb;border-radius:8px;height:14px;width:100%;">
            <div style="width:'.$value.'%;background:'.$color.';
                        height:14px;border-radius:8px;"></div>
        </div>';
    }

    if ($pet->age < 3) {
        $stage = '👶 Baby';
        $stageColor = '#10b981';
    } elseif ($pet->age < 7) {
        $stage = '🧑 Adult';
        $stageColor = '#3b82f6';
    } else {
        $stage = '👴 Old';
        $stageColor = '#ef4444';
    }
@endphp

<div style="margin-bottom:15px;">
    <strong>Health: {{ $pet->health }}</strong>
    {!! bar($pet->health, '#ef4444') !!}
</div>

<div style="margin-bottom:15px;">
    <strong>Energy: {{ $pet->energy }}</strong>
    {!! bar($pet->energy, '#3b82f6') !!}
</div>

<div style="margin-bottom:15px;">
    <strong>Hunger: {{ $pet->hunger }}</strong>
    {!! bar($pet->hunger, '#f59e0b') !!}
</div>

<div style="margin-bottom:15px;">
    <strong>Cleanliness: {{ $pet->cleanliness }}</strong>
    {!! bar($pet->cleanliness, '#10b981') !!}
</div>

<div style="margin-bottom:20px;">
    <strong>Happiness: {{ $pet->happiness }}</strong>
    {!! bar($pet->happiness, '#8b5cf6') !!}
</div>

<div style="padding:12px;background:#f3f4f6;border-radius:10px;text-align:center;font-weight:bold;">
    🎂 {{ $pet->age }} days old<br>
    <span style="color:{{ $stageColor }};font-size:13px;">
        {{ $stage }}
    </span>
</div>

<div style="margin-top:20px;text-align:center;font-weight:bold;
            color: {{ $pet->is_alive ? '#16a34a' : '#dc2626' }};">
    {{ $pet->is_alive ? '🟢 Alive' : '🔴 Dead' }}
</div>

@if($pet->last_event)
<div style="margin-top:15px;padding:12px;background:#fef3c7;
            color:#b45309;border-radius:10px;text-align:center;">
    {{ $pet->last_event }}
</div>
@endif

</td></tr>
</table>

</td>
</tr>
</table>

</body>
</html>