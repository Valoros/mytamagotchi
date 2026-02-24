<!DOCTYPE html>
<html>
<head>
    <title>Create Pet</title>
</head>
<body style="font-family: Arial; padding:40px; background:#f4f6f9;">

    <div style="max-width:400px;margin:0 auto;background:white;
                padding:30px;border-radius:16px;
                box-shadow:0 10px 30px rgba(0,0,0,0.1);">

        <h2>Create your pet</h2>

        <form method="POST" action="{{ route('pets.store') }}">
            @csrf

            <div style="margin-bottom:15px;">
                <label>Name:</label><br>
                <input type="text" name="name" required
                       style="width:100%;padding:8px;border-radius:8px;">
            </div>

            <div style="margin-bottom:20px;">
                <label>Choose pet:</label><br>
                <select name="type" required
                        style="width:100%;padding:8px;border-radius:8px;">
                    <option value="cat">🐱 Cat</option>
                    <option value="dog">🐶 Dog</option>
                    <option value="rabbit">🐰 Rabbit</option>
                </select>
            </div>

            <button type="submit"
                    style="width:100%;padding:10px;border:none;
                           border-radius:8px;background:#111827;
                           color:white;font-weight:bold;">
                Create
            </button>

        </form>

    </div>

</body>
</html>