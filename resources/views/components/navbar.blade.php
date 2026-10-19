
<ul>
    <li class="m-2 p-3"><a href="{{route('home')}}">Home</a></li>
    @guest
        <li  class="m-2 p-3"><a href="{{route('login')}}">Login</a></li>
    @endguest
    @auth
        <li class="m-2 p-3"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="m-2 p-3">
            <form
                action="{{route('logout')}}"
                method="post"
            >
            @csrf
            <button>Logout</button>
            </form>
        </li>
    @endauth
</ul>
