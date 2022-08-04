<style>
    #sakiot-sql-spy{
        position:fixed;
        top:60px;
        right:60px;
    }
    #sakiot-sql-spy a{
        display:table;
        padding:10px;
        background:rgba(120,120,120,.8);
        color:#fff;
        border-radius:2px;
    }
    #sakiot-sql-spy a span{
        display:block;
    }
</style>

<div id="sakiot-sql-spy">
    <a href="{{ route($download_route_name, [], false) }}" onclick="event.preventDefault();document.getElementById('sakiot-sql-spy-form').submit();" target="_blank">
        <span>SQL SPY</span>
        <span>CSV DOWNLOAD</span>
    </a>
</div>

<form id="sakiot-sql-spy-form" action="{{ route($download_route_name, [], false) }}" method="POST" style="display: none;">
    @csrf
</form>