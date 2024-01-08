<div class="container">
    <h1>Update Configuration</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('config.save') }}">
        @csrf
        <div class="form-group">
            <label for="envContent">Configuration Content</label>
            <textarea class="form-control" name="envContent" rows="10">{{ $envContent }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<style>
    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .btn-primary {
        display: block;
        width: 100%;
    }
</style>