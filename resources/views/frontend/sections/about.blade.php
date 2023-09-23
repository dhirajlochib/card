
@php
    $lang = selectedLang();
    $about_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::ABOUT_SECTION);
    $about_sections = App\Models\Admin\SiteSections::getData( $about_slug)->first();
@endphp
<section class="elementor-section elementor-top-section elementor-element elementor-element-077987e elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="077987e" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
						<div class="elementor-container elementor-column-gap-no">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-19dba46" data-id="19dba46" data-element_type="column">
			<div class="elementor-widget-wrap elementor-element-populated">
								<section class="elementor-section elementor-inner-section elementor-element elementor-element-f638e73 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="f638e73" data-element_type="section">
						<div class="elementor-container elementor-column-gap-no">
					<div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-985267c" data-id="985267c" data-element_type="column">
			<div class="elementor-widget-wrap elementor-element-populated">
								<div class="elementor-element elementor-element-ac4f958 elementor-widget elementor-widget-image" data-id="ac4f958" data-element_type="widget" data-widget_type="image.default">
				<div class="elementor-widget-container">
															<img width="300" height="75" src="https://templatekit.jegtheme.com/credigi/wp-content/uploads/sites/247/2022/03/partner-3-300x75-1.png" class="attachment-full size-full wp-image-888" alt="" decoding="async" loading="lazy">															</div>
				</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-92ff3f4" data-id="92ff3f4" data-element_type="column">
			<div class="elementor-widget-wrap elementor-element-populated">
								<div class="elementor-element elementor-element-18368a4 elementor-widget elementor-widget-image" data-id="18368a4" data-element_type="widget" data-widget_type="image.default">
				<div class="elementor-widget-container">
															<img width="300" height="75" src="https://templatekit.jegtheme.com/credigi/wp-content/uploads/sites/247/2022/03/partner-6-300x75-1.png" class="attachment-full size-full wp-image-889" alt="" decoding="async" loading="lazy">															</div>
				</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-3065d17" data-id="3065d17" data-element_type="column">
			<div class="elementor-widget-wrap elementor-element-populated">
								<div class="elementor-element elementor-element-7b2a2ca elementor-widget elementor-widget-image" data-id="7b2a2ca" data-element_type="widget" data-widget_type="image.default">
				<div class="elementor-widget-container">
															<img width="300" height="73" src="https://templatekit.jegtheme.com/credigi/wp-content/uploads/sites/247/2022/03/partner-7-300x73-1.png" class="attachment-full size-full wp-image-890" alt="" decoding="async" loading="lazy">															</div>
				</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-b3df85f" data-id="b3df85f" data-element_type="column">
			<div class="elementor-widget-wrap elementor-element-populated">
								<div class="elementor-element elementor-element-3f3f83e elementor-widget elementor-widget-image" data-id="3f3f83e" data-element_type="widget" data-widget_type="image.default">
				<div class="elementor-widget-container">
															<img width="300" height="71" src="https://templatekit.jegtheme.com/credigi/wp-content/uploads/sites/247/2022/03/partner-8-300x71-1.png" class="attachment-full size-full wp-image-891" alt="" decoding="async" loading="lazy">															</div>
				</div>
					</div>
		</div>
							</div>
		</section>
					</div>
		</div>
							</div>
		</section>
<section class="about-section ptb-80">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="about-thumb">
                    <img src="{{ get_image(@$about_sections->value->images->image,'site-section') }}" alt="element">
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="about-content-wrapper">
                    <div class="about-content-header">
                        <span class="text--base">{{ __(@$about_sections->value->language->$lang->section_title) }}</span>
                        <h2 class="title pt-3">{{ __(@$about_sections->value->language->$lang->heading) }}</h2>
                        <p>{{ __(@$about_sections->value->language->$lang->sub_heading) }}</p>
                        <div class="about-item pt-4">
                            <div class="row">
                                @if(isset($about_sections->value->items))
                                @foreach($about_sections->value->items ?? [] as $key => $item)
                                <div class="col-lg-6">
                                    <div class="item d-flex">
                                        <div class="item-icon">
                                            <i class="{{ @$item->language->$lang->icon }}"></i>
                                        </div>
                                        <div class="item-name">
                                            <P>{{ __(@$item->language->$lang->title )}}</P>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>