@extends('layouts.main')

@section('content')
    <section class="section">
        <div class="container is-fluid has-text-centered">
            <div id="twitch-embed"></div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://embed.twitch.tv/embed/v1.js"></script>
    <script type="text/javascript">
        new Twitch.Embed("twitch-embed", {
            width: 1620,
            height: 720,
            channel: "drecken3",
            theme: "dark"
        });
    </script>
@endsection