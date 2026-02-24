<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $pet->name }}</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            padding: 40px;
        }

        .card {
            background: white;
            width: 420px;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        h1 {
            margin-top: 0;
            text-align: center;
        }

        .stat {
            margin-bottom: 15px;
        }

        .stat-label {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .progress {
            height: 14px;
            background: #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            border-radius: 8px;
            transition: width 0.3s ease;
        }

        .health { background: #ef4444; }
        .energy { background: #3b82f6; }
        .hunger { background: #f59e0b; }
        .clean { background: #10b981; }
        .happy { background: #8b5cf6; }

        .actions {
            margin-top: 25px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        button {
            padding: 10px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            background: #111827;
            color: white;
            transition: 0.2s;
        }

        button:hover {
            opacity: 0.85;
        }

        .status {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }

        .alive { color: #16a34a; }
        .dead { color: #dc2626; }

        .age-box {
            margin-top: 20px;
            padding: 12px;
            border-radius: 10px;
            background: #f3f4f6;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        .age-stage {
            display: block;
            font-size: 13px;
            margin-top: 4px;
            color: #6b7280;
        }
    </style>
</head>
<body>

<div class="card">

    {{-- Имя питомца --}}
    <h1>{{ $pet->name }}</h1>

    {{-- Статусы --}}
    <div class="stat">
        <div class="stat-label">
            <span>Health</span>
            <span>{{ $pet->health }}</span>
        </div>
        <div class="progress">
            <div class="progress-bar health" style="width: {{ $pet->health }}%"></div>
        </div>
    </div>

    <div class="stat">
        <div class="stat-label">
            <span>Energy</span>
            <span>{{ $pet->energy }}</span>
        </div>
        <div class="progress">
            <div class="progress-bar energy" style="width: {{ $pet->energy }}%"></div>
        </div>
    </div>

    <div class="stat">
        <div class="stat-label">
            <span>Hunger</span>
            <span>{{ $pet->hunger }}</span>
        </div>
        <div class="progress">
            <div class="progress-bar hunger" style="width: {{ $pet->hunger }}%"></div>
        </div>
    </div>

    <div class="stat">
        <div class="stat-label">
            <span>Cleanliness</span>
            <span>{{ $pet->cleanliness }}</span>
        </div>
        <div class="progress">
            <div class="progress-bar clean" style="width: {{ $pet->cleanliness }}%"></div>
        </div>
    </div>

    <div class="stat">
        <div class="stat-label">
            <span>Happiness</span>
            <span>{{ $pet->happiness }}</span>
        </div>
        <div class="progress">
            <div class="progress-bar happy" style="width: {{ $pet->happiness }}%"></div>
        </div>
    </div>

    {{-- Возраст и стадия жизни --}}
    @php
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

    <div class="age-box">
        🎂 {{ $pet->age }} days old
        <span class="age-stage" style="color: {{ $stageColor }}">{{ $stage }}</span>
    </div>

    {{-- Действия --}}
    @if($pet->is_alive)
        <div class="actions">
            <form method="POST" action="{{ route('pets.action', [$pet, 'feed']) }}">
                @csrf
                <button type="submit">🍖 Feed</button>
            </form>

            <form method="POST" action="{{ route('pets.action', [$pet, 'sleep']) }}">
                @csrf
                <button type="submit">😴 Sleep</button>
            </form>

            <form method="POST" action="{{ route('pets.action', [$pet, 'play']) }}">
                @csrf
                <button type="submit">🎮 Play</button>
            </form>

            <form method="POST" action="{{ route('pets.action', [$pet, 'wash']) }}">
                @csrf
                <button type="submit">🧼 Wash</button>
            </form>

            <form method="POST" action="{{ route('pets.sendInfo', $pet) }}">
                @csrf
                <button type="submit">📧 Отправить на почту</button>
            </form>
        </div>
    @endif

    {{-- Статус --}}
    <div class="status">
        @if($pet->is_alive)
            <span class="alive">🟢 Alive</span>
        @else
            <span class="dead">🔴 Dead</span>
            <form method="POST" action="{{ route('pets.action', [$pet, 'reset']) }}">
                @csrf
                <button type="submit">🔄 Reset</button>
            </form>
        @endif
    </div>

    @if($pet->last_event)
        <div class="age-box" style="margin-top: 15px; background: #fef3c7; color: #b45309;">
            {{ $pet->last_event }}
        </div>
    @endif

    @if($pet->is_alive)
        <div class="actions">
            <!-- Другие кнопки -->
            <form method="POST" action="{{ route('pets.fastForward', $pet) }}">
                @csrf
                <button type="submit">⏩ Промотать 10 дней</button>
            </form>
        </div>
    @endif
</div>

</body>
</html>