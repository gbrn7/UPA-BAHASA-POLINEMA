@props(['id', 'value', 'name', 'disabled' => false])

<input type="hidden" name="{{ $name }}" id="{{ $id }}_input" value="{{ $value }}" />

<trix-toolbar class="[&_.trix-button]:bg-white [&_.trix-button.trix-active]:bg-gray-300" id="{{ $id }}_toolbar">
</trix-toolbar>

<trix-editor id="{{ $id }}" input="{{ $id }}_input" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' =>
    'trix-content rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
    focus:ring-opacity-50']) !!}
    x-data="{
    upload(event) {
    const data = new FormData();
    data.append('attachment', event.attachment.file);

    window.axios.post('/attachments', data, {
    onUploadProgress(progressEvent) {
    event.attachment.setUploadProgress(
    progressEvent.loaded / progressEvent.total * 100
    );
    },
    }).then(({ data }) => {
    event.attachment.setAttributes({
    url: data.file_url,
    });
    });
    }
    }"
    x-on:trix-attachment-add="upload"
    ></trix-editor>