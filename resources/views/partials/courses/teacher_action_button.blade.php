<div class="btn-group">
    @if ((int) $course->status === \App\Course::PUBLISHED)
        <a href="{{ route('courses.detail',['slug' => $course->slug]) }}" class="btn btn-course">
            <i class="fa fa-eye"></i>{{ __("Detalle") }}
        </a>    
        <a href="{{ route('courses.edit',['slug' => $course->slug]) }}" class="btn btn-warning text-white">
            <i class="fa fa-pencil"></i>{{ __("Editar Curso") }}
        </a>  
        @include('partials.courses.btn_forms.delete')
        
    @elseif((int) $course->status === \App\Course::PENDING)
        <a href="#" class="btn btn-primary text-white">
            <i class="fa fa-eye"></i>{{ __("Curso pendiente de revision") }}
        </a>  
        <a href="{{ route('courses.detail',['slug' => $course->slug]) }}" class="btn btn-course">
            <i class="fa fa-eye"></i>{{ __("Detalle") }}
        </a>  
        <a href="{{ route('courses.edit',['slug' => $course->slug]) }}" class="btn btn-warning text-white">
            <i class="fa fa-pencil"></i>{{ __("Editar Curso") }}
        </a>  
        @include('partials.courses.btn_forms.delete')

    @else
        <a href="#" class="btn btn-danger text-white">
            <i class="fa fa-eye"></i>{{ __("Curso rechazado") }}
        </a>  
        @include('partials.courses.btn_forms.delete')
    @endif
</div>