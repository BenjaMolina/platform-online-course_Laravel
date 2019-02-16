<div class="card card-01">
    <img 
        src="{{ $course->pathAttachment() }}" 
        alt="{{ $course->name }}" 
        class="card-img-top">

    <div class="card-body">
        <div class="badge-box">
            <i class="fa fa-check"></i>
        </div>
        <h4 class="card-title">{{ $course->name }}</h4>
        <hr />
        <div class="row justify-content-center">
            {{-- {{ añadir parcial para mostrar el raiting }} --}}
        </div>
        <hr />
        <span class="badge badge-danger badge-cat">{{ $course->category->name }}</span>
        <p class="card-text">{{ str_limit($course->description, 100) }}</p>
        <a href="#" class="btn btn-course btn-block">
            {{ __('Mas informacion') }}
        </a>
    </div>
</div>