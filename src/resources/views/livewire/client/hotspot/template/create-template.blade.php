<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Create Voucher Template</h6>
            </div>
            <div class="card-body">
                <form
                    wire:submit.prevent="create($('#templateName').val(), cssTemplate.getValue(), htmlTemplate.getValue())">
                    <div class="form-group">
                        <label class="text text-xs text-primary mb-0">Name:</label>
                        <input type="text" id="templateName" class="form-control"placeholder="Enter Template Name"
                            autocomplete="off">
                        @error('templateName')
                            <span class="text text-xs text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group" wire:ignore>
                        <label class="text text-xs text-primary mb-0">Style (CSS):</label>
                        <textarea id="cssEditor" class="form-control" :style="{ 'font-size': '0.7rem' }" cols="30" rows="10">{!! $templateCss !!}</textarea>
                        @error('templateCss')
                            <span class="text text-xs text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group" wire:ignore>
                        <label class="text text-xs text-primary mb-0">Template (HTML):</label>
                        <textarea class="form-control" id="htmlEditor" :style="{ 'font-size': '0.7rem' }" cols="30" rows="10">{{ $templateHtml }}</textarea>
                        @error('templateHtml')
                            <span class="text text-xs text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @error('otherError')
                        <span class="text text-xs text-danger">{{ $message }}</span>
                    @enderror
                    <hr>
                    <div class="d-flex justify-content-start">
                        <a class="btn btn-secondary mr-2" href="{{ route('client.voucher.template') }}">Cancel</a>
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Parameters</h6>
            </div>
            <div class="card-body text-md">
                <ul>
                    <li>
                        <span class="text text-info">"voucher.id"</span>
                        <ul>
                            <li class="text-xs">
                                Unique ID of Voucher
                            </li>
                        </ul>
                    </li>

                    <li>
                        <span class="text text-info">"voucher.code"</span>
                        <ul>
                            <li class="text-xs">
                                The CODE / Username of Voucher
                            </li>
                        </ul>
                    </li>

                    <li>
                        <span class="text text-info">"voucher.description"</span>
                        <ul>
                            <li class="text-xs">
                                Description of Hotspot Profile
                            </li>
                        </ul>
                    </li>

                    <li>
                        <span class="text text-info">"voucher.profile"</span>
                        <ul>
                            <li class="text-xs">
                                The name of Hotspot Profile
                            </li>
                        </ul>
                    </li>

                    <li>
                        <span class="text text-info">"voucher.price"</span>
                        <ul>
                            <li class="text-xs">
                                The Price of Hotspot Profile
                            </li>
                        </ul>
                    </li>

                    <li>
                        <span class="text text-info">"voucher.time_limit"</span>
                        <ul>
                            <li class="text-xs">
                                The Time Limit of Voucher
                            </li>
                        </ul>
                    </li>

                    <li>
                        <span class="text text-info">"voucher.data_limit"</span>
                        <ul>
                            <li class="text-xs">
                                The Data Limit of Voucher
                            </li>
                        </ul>
                    </li>

                    <li>
                        <span class="text text-info">"voucher.speed_max_download"</span>
                        <ul>
                            <li class="text-xs">
                                The download speed of Voucher
                            </li>
                        </ul>
                    </li>

                    <li>
                        <span class="text text-info">"voucher.speed_max_upload"</span>
                        <ul>
                            <li class="text-xs">
                                The upload speed of Voucher
                            </li>
                        </ul>
                    </li>

                    <li>
                        <span class="text text-info">"voucher.validity"</span>
                        <ul>
                            <li class="text-xs">
                                The expiration / validity of Voucher
                            </li>
                        </ul>
                    </li>

                    <li>
                        <span class="text text-info">"voucher.reseller_name"</span>
                        <ul>
                            <li class="text-xs">
                                Name of the Reseller of this Voucher
                            </li>
                        </ul>
                    </li>

                    <li>
                        <span class="text text-info">"voucher.reseller_id"</span>
                        <ul>
                            <li class="text-xs">
                                ID of the Reseller of this Voucher
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
            <div class="card-footer">
                <span class="text text-xs">
                    <b>Note:</b> Use AlpineJS`s <span class="text-danger">x-text</span> to display the value
                    of parameter
                </span>
            </div>
        </div>
    </div>
</div>


@push('scripts-bottom')
    <script src="{{ asset('js/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('js/codemirror/closetag.js') }}"></script>
    <script src="{{ asset('js/codemirror/xml-fold.js') }}"></script>
    <script src="{{ asset('js/codemirror/xml.js') }}"></script>
    <script src="{{ asset('js/codemirror/javascript.js') }}"></script>
    <script src="{{ asset('js/codemirror/css.js') }}"></script>
    <script src="{{ asset('js/codemirror/htmlmixed.js') }}"></script>
    <script src="{{ asset('js/codemirror/closebrackets.js') }}"></script>
    <script src="{{ asset('js/codemirror/matchbrackets.js') }}"></script>
    <script src="{{ asset('js/codemirror/matchtags.js') }}"></script>
    <script src="{{ asset('js/codemirror/sublime.js') }}"></script>
    <script src="{{ asset('js/codemirror/comment.js') }}"></script>
    <script src="{{ asset('js/codemirror/clike.js') }}"></script>
    <script src="{{ asset('js/codemirror/php.js') }}"></script>
    <script src="{{ asset('js/codemirror/searchcursor.js') }}"></script>
    <script src="{{ asset('js/codemirror/search.js') }}"></script>
    <script src="{{ asset('js/codemirror/dialog.js') }}"></script>
    <script src="{{ asset('js/codemirror/annotatescrollbar.js') }}"></script>
    <script src="{{ asset('js/codemirror/matchesonscrollbar.js') }}"></script>
    <script src="{{ asset('js/codemirror/jump-to-line.js') }}"></script>
    <script>
        let cssTemplate = CodeMirror.fromTextArea(cssEditor, {
            lineNumbers: true,
            mode: 'css',
            theme: 'dracula',
            fontSize: '0.7rem'
        });

        let htmlTemplate = CodeMirror.fromTextArea(htmlEditor, {
            lineNumbers: true,
            mode: 'htmlmixed',
            theme: 'dracula',
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/editor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dracula.css') }}">
    <style>
        .CodeMirror {
            font-size: 0.7rem;
        }
    </style>
@endpush
