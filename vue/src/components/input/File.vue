<script>
export default {
    props: {
        item: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            options: this.item.options,
            inputOptions: this.item.options.file ?? {},
            items: [],
            fileInputOptions: {
                initialPreviewAsData: true,
                showCaption: false,
                showUpload: false,
                showRemove: false,
                showDelete: false,
                showCancel: false,
                showClose: false,
                browseOnZoneClick: true,

                overwriteInitial: this.item.options.file?.willOverride ?? false,

                browseClass: 'btn btn-primary btn-block',
                browseIcon: '<i class="fas fa-folder-open"></i>',
                removeClass: 'btn btn-danger btn-block float-right mt-1 mb-2',
                removeIcon: '<i class="fas fa-trash-alt"></i>',

                fileActionSettings: {
                    showDrag: false,
                    dragClass: 'text-primary',
                    dragIcon: '<i class="fas fa-arrows-alt"></i>',
                    zoomClass: 'btn btn-info',
                    zoomIcon: '<i class="fas fa-search-plus"></i>',
                    downloadClass: 'btn btn-primary pull-left',
                    downloadIcon: '<i class="fas fa-cloud-download-alt"></i>',
                    removeClass: 'btn btn-danger',
                    removeIcon: '<i class="fas fa-trash-alt"></i>',
                },
                previewZoomButtonIcons: {
                    prev: '<i class="fas fa-caret-left"></i>',
                    next: '<i class="fas fa-caret-right"></i>',
                    toggleheader: '<i class="far fa-window-maximize"></i>',
                    fullscreen: '<i class="fas fa-compress"></i>',
                    borderless: '<i class="fas fa-arrows-alt"></i>',
                    close: '<i class="fas fa-times"></i>',
                },

                ajaxDeleteSettings: {
                    type: 'DELETE',
                    headers: this.booted.config.http.headers,
                },
            },
        };
    },
    mounted() {
        this.collectItems();

        let layoutTemplates = {
            actions: '{drag}<div class="file-actions">' + '<div class="file-footer-buttons">{zoom} {download} {delete}</div>' + '</div>',
        };

        if (!this.inputOptions.deleteUrl) {
            layoutTemplates.actions = layoutTemplates.actions.replace('{delete}', '');
        }

        this.fileInputOptions.layoutTemplates = layoutTemplates;
        this.fileInputOptions.initialPreview = this.items.map((value, key) => value.previewUrl);
        this.fileInputOptions.initialPreviewConfig = this.items;

        $('#' + this.item.id).fileinput(this.fileInputOptions);

        $('#' + this.item.id).on('filedeleted', (event, key) => {
            if (this.options.isMultiple) {
                this.item.value.splice(key, 1);
                this.collectItems();

                this.fileInputOptions.initialPreview = this.items.map((value, key) => value.previewUrl);
                this.fileInputOptions.initialPreviewConfig = this.items;

                $('#' + this.item.id)
                    .fileinput('destroy')
                    .fileinput(this.fileInputOptions);
            }
        });
    },
    methods: {
        collectItems() {
            let items = [],
                value = this.item.value;

            if (!value) return;

            if (!this.options.isMultiple) {
                value = [value];
            }

            for (let key in value) {
                let file = value[key],
                    deleteUrl = this.inputOptions.deleteUrl;

                if (deleteUrl) {
                    deleteUrl = deleteUrl.replace(':id', this.$route.params.id).replace(':index', key);
                }

                let downloadUrl = this.inputOptions.downloadPath ? file[this.inputOptions.downloadPath] : file,
                    fileInfo = this.booted.helpers.file.info(downloadUrl);

                items[key] = {
                    key: key,
                    caption: this.__('Файл №:index', { index: parseInt(key) + 1 }),
                    type: fileInfo.type ?? 'html',
                    filetype: fileInfo.mimeType,
                    previewUrl: this.inputOptions.previewPath ? file[this.inputOptions.previewPath] : file,
                    downloadUrl: downloadUrl,
                    url: this.booted.config.http.url + '/' + deleteUrl,
                };
            }

            this.items = items;
        },
    },
};
</script>

<template>
    <input type="file" :multiple="options.isMultiple" />
</template>
