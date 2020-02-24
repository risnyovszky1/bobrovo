<template>
    <div class="editor">
        <vue-editor
            v-model="html"
            :editor-toolbar="customToolbar"
            useCustomImageHandler
            @imageAdded="handleImageAdded"/>

        <textarea
            :name="name"
            :id="name"
            class="d-none"
            v-model="html">
        </textarea>

    </div>
</template>

<script>
    // Basic Use - Covers most scenarios
    import {VueEditor} from "vue2-editor";
    import axios from "axios";

    export default {
        components: {VueEditor},
        props: {
            content: {
                required: true,
                default: '',
            },
            name: {
                default: '',
            }
        },
        data() {
            return {
                html: '',
                customToolbar: [
                    [{'header': [1, 2, 3, 4, 5, 6, false]}],
                    ["bold", "italic", "underline"],
                    [{list: "ordered"}, {list: "bullet"}],
                    ["image", "code-block"]
                ],
            }
        },
        methods: {
            handleImageAdded: function (file, Editor, cursorLocation, resetUploader) {
                var formData = new FormData();
                formData.append("image", file);
                console.dir('asdasdasd');
                axios({
                    url: "/upload-img",
                    method: "POST",
                    data: formData
                })
                    .then(result => {
                        let url = result.data.url; // Get url from response
                        Editor.insertEmbed(cursorLocation, "image", url);
                        resetUploader();
                    })
                    .catch(err => {
                        console.log(err);
                    });
            }
        },
        mounted() {
            this.html = this.content;
        }
    }
</script>

<style>
    @import '~quill/dist/quill.core.css';
    @import '~quill/dist/quill.bubble.css';
</style>
