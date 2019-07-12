<!-- Categories Homepage Section Start -->
<section id="categories" class="section-padding bg-drack">
    <div class="container">
        <div class="row">
            @foreach($parent_categories as $super_category)
            <div class="col-lg-3 col-md-6 col-xs-12">
                <div class="category-box">
                    <div class="icon">
                        <a href="{{ route('super_category_index', ['category' => $super_category->description->slug]) }}">
                            <i class="lni-{{ $super_category->icon }}"></i>
                        </a>
                    </div>
                    <div class="category-header">
                        <a href="{{ route('super_category_index', ['category' => $super_category->description->slug]) }}">
                            <h4>{{ $super_category->description->name }}
                                <!--(XXXX)-->
                            </h4>
                        </a>
                    </div>
                    <div class="category-content">
                        <ul>
                            @foreach($category_formatted[$super_category->id] as $category)
                            <li>
                                <a href="{{ route('category_index', ['category' => $super_category->description->slug, 'subcategory' => $category->slug]) }}">
                                    <span>{{ $category->name }}</span>
                                    <span></span>
                                </a>
                            </li>

                            {{-- Breaking this foreach at 6 subcategories, try to pass to JQuery and show all --}}
                            @if($loop->index >= 5)
                            <li>
                                <a href="{{ route('super_category_index', ['category' => $super_category->description->slug]) }}">
                                    <span>Ver Todo <i class="lni-arrow-right"></i></span>
                                </a>
                            </li>
                            @break
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Categories Homepage Section End -->