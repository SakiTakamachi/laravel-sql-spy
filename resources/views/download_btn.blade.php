
<style>
    #laravel-sql-spy{
        position:fixed;
        top:60px;
        right:60px;
    }
    #laravel-sql-spy a{
        display:table;
        padding:10px;
        background:rgba(120,120,120,.8);
        color:#fff;
        border-radius:2px;
    }
    #laravel-sql-spy a span{
        display:block;
    }
</style>

<div id="laravel-sql-spy">
    <a href="{{ route($download_route_name, [], false) }}" onclick="event.preventDefault();document.getElementById('laravel-sql-spy-form').submit();" target="_blank">
        <span>SQL SPY</span>
        <span>CSV DOWNLOAD</span>
    </a>
</div>

<form id="laravel-sql-spy-form" action="{{ route($download_route_name, [], false) }}" method="POST" style="display: none;">
    @csrf
</form>
