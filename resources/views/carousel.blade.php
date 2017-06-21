<?php
/**
 * @author Jonathon Wallen
 * @date 9/6/17
 * @time 5:21 PM
 * @copyright 2008 - present, Monkii Digital Agency (http://monkii.com.au)
 */
?>

<div class="panel {{ $errors->has('sections.' . $section->id . '.data.0.image') ? 'error' : '' }}">
    <div class="panel__inner">

        <div class="panel__row--tight">
            <div class="panel__full">
                <h3>Carousel</h3>
            </div>
            <hr>
        </div>
        <div class="panel__row">
            <div class="panel__full">
                {!! Form::hidden('sections[' . $section->id . '][type]', 'carousel') !!}
                {!! Form::hidden('sections[' . $section->id . '][delta]', $section->delta) !!}
                <ul class="carousel sortable">
                @if($section->data)
                    @php($cnt = 0)
                    @foreach($section->data as $key => $item)
                        <li class="carousel-item" data-num="" style="background-image:url('{{ $item['image'] }}')">
                            <span class="carousel-heading">{{ $item['title'] }}</span>

                            <input class="carousel_title"      name="sections[{{ $section->id }}][data][{{ $cnt }}][title]"      value="{{ $item['title'] }}" type="hidden">
                            <input class="carousel_sub_title"  name="sections[{{ $section->id }}][data][{{ $cnt }}][sub_title]"  value="{{ $item['sub_title'] }}" type="hidden">
                            <input class="carousel_link"       name="sections[{{ $section->id }}][data][{{ $cnt }}][link]"       value="{{ $item['link'] }}" type="hidden">
                            <input class="carousel_link_title" name="sections[{{ $section->id }}][data][{{ $cnt }}][link_title]" value="{{ $item['link_title'] }}" type="hidden">
                            <input class="carousel_image"      name="sections[{{ $section->id }}][data][{{ $cnt }}][image]"      value="{{ $item['image'] }}" type="hidden">

                            <div class="carousel-delete"><svg class="icon icon-bin"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-bin"></use></svg></div>
                        </li>
                        @php($cnt++)
                    @endforeach
                @endif
                </ul>
            </div>
            <hr>
        </div>

        <div class="panel__row">
            <div class="panel__full  carousel-add">
                <fieldset class="panel__row  panel__left  panel__full">
                    <h4 class="full">Title <span class="right">(optional)</span></h4>
                    {!! Form::text('carousel_add_title') !!}
                </fieldset>
                <fieldset class="panel__row  panel__left  panel__full">
                    <h4 class="full">Sub-Title <span class="right">(optional)</span></h4>
                    {!! Form::text('carousel_add_sub_title') !!}
                </fieldset>
                <fieldset class="panel__row  panel__left  panel__full">
                    <h4>Link</h4>
                    {!! Form::text('carousel_add_link') !!}
                </fieldset>
                {{--<fieldset class="panel__row  panel__left  panel__full">
                    <h4 class="full">Link Title <span class="right">(optional)</span></h4>
                    {!! Form::text('carousel_add_link_title') !!}
                </fieldset>--}}
                <fieldset class="panel__row  panel__full">
                    <h4>Image <span>(831px Width x 501px Height)</span></h4>
                    <input name="carousel_add_image" id="carousel_add_image" value="" type="hidden">
                    <div class="asset" data-id="carousel_add_image" data-title="Carousel Image (831px Width x 501px Height)"></div>
                    <div class="form__error">{{ $errors->first('sections.' . $section->id . '.data.0.image') }}</div>
                </fieldset>
                <fieldset class="panel__row">
                    <a href="" class="btn  btn--primary">
                        <span class="plus-span"><svg class="icon icon-plus-circle"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-plus-circle"></use></svg></span>
                        Add new carousel item
                    </a>
                </fieldset>
            </div>
        </div>

    </div>
</div>

@section('scripts')
    @parent

    <script type="text/javascript">
        $(document).ready(function() {

            var id = 0;
            $(".carousel-add .btn").click(function(e) {
                e.preventDefault();

                // Validation
                if (!carouselSetupValidation()) return false;

                // Populate template
                var carouselItem = $.parseHTML($("#carousel_item_template").html());
                $(carouselItem).filter(".carousel-item").attr("style", "background-image:url(" + $("input[name='carousel_add_image']").val() + ")");

                $(carouselItem).find(".carousel-heading").html($("input[name='carousel_add_title']").val());

                var title = $(carouselItem).find(".carousel_title");
                title.val($("input[name='carousel_add_title']").val());
                title.attr('name', 'sections[{{ $section->id }}][data][' + id + '][title]');

                var subTitle = $(carouselItem).find(".carousel_sub_title");
                subTitle.val($("input[name='carousel_add_sub_title']").val());
                subTitle.attr('name', 'sections[{{ $section->id }}][data][' + id + '][sub_title]');

                var link = $(carouselItem).find(".carousel_link");
                link.val($("input[name='carousel_add_link']").val());
                link.attr('name', 'sections[{{ $section->id }}][data][' + id + '][link]');

                var linkTitle = $(carouselItem).find(".carousel_link_title");
                linkTitle.val($("input[name='carousel_add_link_title']").val());
                linkTitle.attr('name', 'sections[{{ $section->id }}][data][' + id + '][link_title]');

                var image = $(carouselItem).find(".carousel_image");
                image.val($("input[name='carousel_add_image']").val());
                image.attr('name', 'sections[{{ $section->id }}][data][' + id + '][image]');

                $(carouselItem).find(".carousel-delete").click(function() {
                    carouselRemoveItem($(this));
                });

                // Insert and refresh sortable
                if (!$(".carousel.sortable .carousel-item").length) {
                    $(".carousel.sortable").append(carouselItem);
                    $(".carousel.sortable").sortable();
                    $(".carousel.sortable").disableSelection();
                }
                else {
                    $(".carousel.sortable").append(carouselItem);
                    $(".carousel.sortable").sortable('refresh');
                    $(".carousel.sortable").disableSelection();
                }

                // Clear the input form
                $("input[name='carousel_add_title']").val("");
                $("input[name='carousel_add_sub_title']").val("");
                $("input[name='carousel_add_link']").val("");
                $("input[name='carousel_add_link_title']").val("");
                $("input[name='carousel_add_image']").val("");
                assetInit();
                id++;
            });

        });

        function carouselRemoveItem(_this) {
            var item = $(_this).closest(".carousel-item");
            $(item).remove();

            $(".carousel.sortable").sortable('refresh');
            $(".carousel.sortable").disableSelection();
        }

        function carouselSetupValidation() {
            var fail = 0;
//            $("fieldset.error").removeClass("error");

//            // Check if "Link" is valid
//            if (!is_url_valid($("input[name='carousel_add_link']").val())) {
//                fail++;
//                $("input[name='carousel_add_link']").closest("fieldset").addClass("error");
//            }

            // Check if "Image" is set
            if ($("input[name='carousel_add_image']").val() === "") {
                fail++;
                $("input[name='carousel_add_image']").closest("fieldset").addClass("error");
            }

            if (fail) return false;
            return true;
        }
    </script>

    <script type="text/html" id="carousel_item_template">
        <li class="carousel-item" data-num="" style="">
            <span class="carousel-heading"></span>

            <input class="carousel_title"      name="carousel_title"      value="" type="hidden">
            <input class="carousel_sub_title"  name="carousel_sub_title"  value="" type="hidden">
            <input class="carousel_link"       name="carousel_link"       value="" type="hidden">
            <input class="carousel_link_title" name="carousel_link_title" value="" type="hidden">
            <input class="carousel_image"      name="carousel_image"      value="" type="hidden">

            <div class="carousel-delete"><svg class="icon icon-bin"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-bin"></use></svg></div>
        </li>
    </script>
@endsection