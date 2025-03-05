@extends('web.layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/web/course/index.css', true) }}">
@endpush

@section('content')
    <div class="banner-wrapper" style="margin-top: 53px">
        <section class="courses-banner position-relative overflow-hidden py-20">
            <!-- Animated Background Grid -->
            <div class="animated-grid banner-element"></div>

            <!-- Gradient Overlay -->
            <div class="gradient-overlay banner-element"></div>

            <!-- Animated Shapes -->
            <div class="banner-bg-elements">
                <div class="banner-shape-1 banner-element"></div>
                <div class="banner-shape-2 banner-element"></div>
                <div class="banner-shape-3 banner-element"></div>
            </div>

            <div class="container position-relative z-1">
                <div class="row align-items-center">
                    <div class="col-lg-6 text-center text-lg-start">
                        <div class="banner-content">
                            <x-web.section-badge title="FEATURED COURSES" class="mb-4 banner-element" />
                            <h1 class="display-4 fw-bolder mb-4 banner-title banner-element">
                                Unlock Your Potential<br>
                                <span class="gradient-text">With Expert-Led Courses</span>
                            </h1>
                            <p class="lead fs-3 mb-5 banner-subtitle banner-element">
                                Join thousands of learners advancing their careers through our comprehensive courses
                            </p>

                            <!-- Stats Row -->
                            <div class="banner-stats d-flex gap-4 mb-5 banner-element">
                                <div class="stat-item text-center">
                                    <div class="stat-value fw-bold display-6 gradient-text">
                                        {{ count($courses) ? count($courses) - 1 : 0 }}+</div>
                                    <div class="stat-label text-muted">Total Courses</div>
                                </div>
                                <div class="stat-item text-center">
                                    <div class="stat-value fw-bold display-6 gradient-text">{{ $coursesViewCount }}</div>
                                    <div class="stat-label text-muted">Total Views</div>
                                </div>
                                <div class="stat-item text-center">
                                    <div class="stat-value fw-bold display-6" style=" color: white;">
                                        ❤️
                                    </div>
                                    <div class="stat-label text-muted">Never Stop</div>
                                </div>
                            </div>

                            <!-- Enhanced Search Form -->
                            <div class="search-wrapper banner-element">
                                <form class="search-form" id="filterByNameForm" action="#" method="GET">
                                    <div class="input-group input-group-lg rounded-pill">
                                        <input type="text" class="form-control search-input" name="name"
                                            placeholder="What do you want to learn today?" aria-label="Search for courses">
                                        <button id="filterByNameButton" class="btn bg-logo search-btn px-4" type="submit">
                                            <span class="input-group-text search-icon">
                                                <i class="bi text-white fs-4 bi-search"></i>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="banner-illustration banner-element">
                            <img src="{{ asset('core/vendor/img/courses/course.svg') }}" alt="Learning Illustration"
                                class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Filter System -->
    <div class="collapse" id="filterDrawer">
        <div class="filter-drawer">
            <div class="container">
                <div class="filter-header d-flex justify-content-between align-items-center mb-4">
                    <h5 class="m-0">Filter Courses</h5>
                    <button class="btn-close" data-bs-toggle="collapse" data-bs-target="#filterDrawer"></button>
                </div>

                <form class="row g-4" id="filterForm">
                    <!-- Search by Name -->
                    <div class="col-md-4">
                        <div class="filter-group">
                            <label>Search by Name</label>
                            <div class="input-group">
                                <span class="input-filter-icon">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Type course name..." name="name">
                            </div>
                        </div>
                    </div>

                    <!-- Difficulty Level -->
                    <div class="col-md-4">
                        <div class="filter-group">
                            <label>Difficulty Level</label>
                            <select class="form-select" name="difficulty_level">

                                <option value="">All Levels</option>
                                <option value="1">Beginner (1)</option>
                                <option value="2">Elementary (2)</option>
                                <option value="3">Intermediate (3)</option>
                                <option value="4">Advanced (4)</option>
                                <option value="5">Expert (5)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Date Filter -->
                    <div class="col-md-4">
                        <div class="filter-group">
                            <label>Published Date</label>
                            <select class="form-select" name="published_date">
                                <option value="">All Time</option>
                                <option value="today">Today</option>
                                <option value="this_week">This Week</option>
                                <option value="this_month">This Month</option>
                                <option value="last_3_months">Last 3 Months</option>
                                <option value="this_year">This Year</option>
                            </select>
                        </div>
                    </div>

                    <!-- Duration Filter -->
                    <div class="col-md-4">
                        <div class="filter-group">
                            <label>Duration (Hours)</label>
                            <div class="d-flex gap-2">
                                <div class="input-group">
                                    <input type="number" name="duration_min" class="form-control" placeholder="Min">
                                    <span class="input-filter-icon">hr</span>
                                </div>
                                <div class="input-group">
                                    <input type="number" name="duration_max" class="form-control" placeholder="Max">
                                    <span class="input-filter-icon">hr</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sort By -->
                    <div class="col-md-4">
                        <div class="filter-group">
                            <label>Sort By</label>
                            <select class="form-select" name="sort_by">
                                <option value="">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="difficulty_asc">Difficulty (Low to High)</option>
                                <option value="difficulty_desc">Difficulty (High to Low)</option>
                                <option value="duration_asc">Duration (Short to Long)</option>
                                <option value="duration_desc">Duration (Long to Short)</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="filter-footer mt-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <button id="filterButton" class="btn bg-logo" data-bs-toggle="collapse"
                            data-bs-target="#filterDrawer">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add overlay -->
    <div class="filter-overlay" data-bs-toggle="collapse" data-bs-target="#filterDrawer"></div>

    <section class="py-5">
        <div class="container app-bg">
            <div class="active-filter-wrapper-header d-flex align-items-start flex-wrap justify-content-between mb-4">
                <div>
                    <h2 class="mb-0">All Courses</h2>
                    <p class="text-muted mb-0">Explore our collection of {{ count($courses) }} courses</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="active-filters d-flex gap-2 flex-wrap">
                        <!-- Active filters will be added here dynamically -->
                    </div>
                    <div class="filter-actions d-flex gap-2">
                        <button class="filter-trigger-btn" data-bs-toggle="collapse" data-bs-target="#filterDrawer">
                            <i class="bi bi-funnel"></i>
                            <span>Filter Quizzes</span>
                        </button>
                        <button class="btn btn-light rounded-pill" id="clearFilterButton">
                            <i class="bi bi-arrow-counterclockwise fs-2"></i>Reset
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add this active filters section -->
            <div class="active-filters-wrapper mb-4" style="display: none">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="active-filters d-flex gap-2 flex-wrap">
                        <!-- Active filters will be added here dynamically -->
                    </div>
                </div>
            </div>

            <!-- Rest of your courses grid -->
            <div class="row g-6 g-xl-9 courses-section">
                @foreach ($courses as $course)
                    <!-- ... existing course cards ... -->
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('core/packages/gsap/gsap.min.js') }}"></script>
    <script src="{{ asset('js/web/course/index.js') }}" type="module"></script>
@endpush
