
<template>
  <Head title="Post Property" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 col-md-10 col-sm-12 mx-auto d-block">
          <!-- <div class="col-lg-6 col-xl-6 col-md-12 d-block mx-auto"> -->
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active">
              <div class="single-page w-100 p-0">
                <div class="wrapper wrapper2">
                  <form
                    id="register_form"
                    class="card-body"
                    @submit.prevent="submitForm"
                  >
                    <h3 class="pb-1">Profile Photo Update</h3>
                    <p class="text-dark">Upload New Profile Photo</p>

                    <input type="hidden" name="_token" :value="csrf" />

                    <div class="row mt-5">
                      <file-pond
                        name="imageFilepond"
                        ref="pond"
                        v-bind:allow-multiple="true"
                        :imagePreviewMinHeight="100"
                        accepted-file-types="image/png, image/jpeg"
                        v-bind:server="{
                          url: '',
                          timeout: 7000,
                          process: {
                            url: '/upload-images',
                            method: 'POST',
                            headers: {
                              'X-CSRF-TOKEN': csrf_token,
                            },
                            withCredentials: false,
                            onload: handleFilePondLoad,
                            onerror: () => {},
                          },
                        }"
                        v-bind:file="myFiles"
                        v-on:init="handleFilePondInit"
                      ></file-pond>
                    </div>
                    <div class="submit">
                      <button
                        type="submit"
                        class="btn btn-primary btn-block mb-5"
                      >
                        <strong>UPDATE PHOTO </strong>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";

import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Import image preview plugin styles
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Import the plugin code
import FilePondPluginFilePoster from "filepond-plugin-file-poster";

// Import the plugin styles
import "filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css";

// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

import { useForm } from "@inertiajs/inertia-vue3";

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFilePoster
);

export default {
  props: {
    towns: Object,
    message: String,
  },
  components: { Head, FilePond },
  data() {
    return {
      myImages: [],
      csrf_token: $('meta[name="csrf-token"]').attr("content"),
      fileUploadEnable: true,
      form: useForm({
        town: "",
        subRegion: "",
        propertyTitle: "",
        images: "",
        step: "new",
        uploadedImages: [],
      }),
    };
  },
  methods: {
    addFormImage(image) {
      let arr = [];
      this.form.uploadedImages.push(image);
    },
    removeFormImage(image) {},
    handleFilePondInit(response) {},
    handleFilePondLoad(response) {
      this.addFormImage(response);
      return response;
    },

    handlefilePondRevert(uniqueId, load, error) {
      this.removeFormImage(uniqueId);
    },
    townChangeEvent(val) {
      //console.log(val);
      alert(val);
    },

    submitForm() {
      this.form.post("/dashboard/upload-profile-photo", this.form, {
        forceFormData: true,
        onStart: () => (isEnabled.value = false),
        onFinish: () => {
          isEnabled.value = true;
        },
      });
    },
  },
};
</script>


<style>
</style>

