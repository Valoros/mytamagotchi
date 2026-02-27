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

        .layout {
            display: flex;
            gap: 30px;
            align-items: flex-start;
        }

        .main {
            flex: 1;
        }

        .sidebar {
            width: 250px;
            background: white;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .pet-item {
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            background: #f3f4f6;
            text-decoration: none;
            display: block;
            color: #111827;
            font-weight: bold;
        }

        .pet-item:hover {
            background: #e5e7eb;
        }

        .pet-active {
            background: #111827;
            color: white;
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
<body style="margin:0;font-family:Arial,sans-serif;background:#f4f6f9;padding:40px;">

<div class="layout" style="display:flex;gap:30px;align-items:flex-start;max-width:1000px;margin:0 auto;">

    <!-- MAIN -->
    <div class="main" style="flex:1;">

        <div class="card">

            @if(session('success'))
                <div style="background:#d1fae5;color:#065f46;padding:10px;
                            border-radius:8px;margin-bottom:15px;text-align:center;">
                    {{ session('success') }}
                </div>
            @endif

            <h1>
                @if($pet->type === 'cat') 🐱 @endif
                @if($pet->type === 'dog') 🐶 @endif
                @if($pet->type === 'rabbit') 🐰 @endif
                {{ $pet->name }}
            </h1>

            <!-- СТАТЫ -->
            @foreach([
                'Health' => ['value' => $pet->health, 'class' => 'health'],
                'Energy' => ['value' => $pet->energy, 'class' => 'energy'],
                'Hunger' => ['value' => $pet->hunger, 'class' => 'hunger'],
                'Cleanliness' => ['value' => $pet->cleanliness, 'class' => 'clean'],
                'Happiness' => ['value' => $pet->happiness, 'class' => 'happy'],
            ] as $label => $stat)

                <div class="stat">
                    <div class="stat-label">
                        <span>{{ $label }}</span>
                        <span>{{ $stat['value'] }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar {{ $stat['class'] }}"
                             style="width: {{ $stat['value'] }}%"></div>
                    </div>
                </div>

            @endforeach

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
                <span class="age-stage" style="color: {{ $stageColor }}">
                    {{ $stage }}
                </span>
            </div>

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

                </div>

                <div style="margin:20px 0;border-top:1px solid #e5e7eb;"></div>
                <div class="actions">
                    
                    <form method="POST" action="{{ route('pets.sendInfo', $pet) }}">
                        @csrf
                        <button type="submit">📧 Отправить на почту</button>
                    </form>

                    <form method="POST" action="{{ route('pets.fastForward', $pet) }}">
                        @csrf
                        <button type="submit">⏩ Промотать 10 дней</button>
                    </form>

                </div>
            @endif

            <div class="status">
                @if($pet->is_alive)
                    <span class="alive">🟢 Alive</span>
                @else
                    <span class="dead">🔴 Dead</span>
                @endif
            </div>

            @if($pet->last_event)
                <div class="age-box"
                     style="margin-top:15px;background:#fef3c7;color:#b45309;">
                    {{ $pet->last_event }}
                </div>
            @endif

        </div>
    </div>

    <!-- SIDEBAR -->
    <div class="sidebar"
         style="width:250px;background:white;padding:20px;
                border-radius:16px;
                box-shadow:0 10px 30px rgba(0,0,0,0.1);">

        <h3>🐾 Ваши питомцы</h3>

        @foreach($pets as $listPet)
            <a href="{{ route('pets.show', $listPet) }}"
               style="display:block;padding:10px;border-radius:10px;
                      margin-bottom:10px;text-decoration:none;
                      font-weight:bold;
                      background: {{ $listPet->id === $pet->id ? '#111827' : '#f3f4f6' }};
                      color: {{ $listPet->id === $pet->id ? 'white' : '#111827' }};">

                {{ $listPet->name }}
                <br>
                <small>
                    {{ $listPet->is_alive ? '🟢 Alive' : '🔴 Dead' }}
                </small>
            </a>
        @endforeach

        <a href="{{ route('pets.create') }}"
           style="display:block;margin-top:15px;
                  padding:10px;border-radius:10px;
                  background:#111827;color:white;
                  text-align:center;text-decoration:none;font-weight:bold;">
            ➕ Новый питомец
        </a>

    </div>

</div>

</body>
</html>