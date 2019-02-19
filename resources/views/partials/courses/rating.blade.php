<div>
    <ul class="list-inline">
        <ul class="list-inline">
            <li class="list-inline-item">
                <i class="fa fa-star {{ $course->raiting >= 1 ? "yellow" : '' }}"></i>
                <i class="fa fa-star {{ $course->raiting >= 2 ? "yellow" : '' }}"></i>
                <i class="fa fa-star {{ $course->raiting >= 3 ? "yellow" : '' }}"></i>
                <i class="fa fa-star {{ $course->raiting >= 4 ? "yellow" : '' }}"></i>
                <i class="fa fa-star {{ $course->raiting >= 5 ? "yellow" : '' }}"></i>
            </li>
        </ul>
    </ul>
</div>