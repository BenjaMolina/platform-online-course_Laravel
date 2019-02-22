
<div class="col-2">
    
    @auth
        @can('opt_for_course',$course)
            @can('subscribe', App\Course::class)
               <a href="#" class="btn btn-subscribe btn-bottom btn-block">
                    <i class="fa fa-bolt">{{ __(" Subscribirme") }}</i> 
               </a>     
            @else
                @can('inscribe', $course)
                   <a href="#" class="btn btn-subscribe btn-bottom btn-block">
                        <i class="fa fa-bolt">{{ __(" Inscribirme") }}</i> 
                   </a>
                @else
                    <a href="#" class="btn btn-subscribe btn-bottom btn-block">
                        <i class="fa fa-bolt">{{ __(" Inscrito") }}</i> 
                    </a>
                @endcan
            @endcan    
        @else
            <a href="#" class="btn btn-subscribe btn-bottom btn-block">
                <i class="fa fa-user">{{ __(" Soy Autor") }}</i> 
            </a>
        @endcan
    @else
        <a href="{{ route('login') }}" class="btn btn-subscribe btn-bottom btn-block">
            <i class="fa fa-user">{{ __(" Acceder") }}</i> 
       </a>
    @endauth
</div>