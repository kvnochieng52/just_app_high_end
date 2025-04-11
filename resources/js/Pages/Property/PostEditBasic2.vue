
<template>
  <Head title="Post Property" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-10 col-sm-12 mx-auto d-block">
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
                    <h3 class="pb-1">Edit Property</h3>

                    <span class="text-dark text_grayish">Step 1 of 3</span>
                    <div class="progress">
                      <div
                        class="progress-bar bg-info progress-bar-striped gold"
                        role="progressbar"
                        style="width: 33%"
                        aria-valuenow="33"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      >
                        <strong>33%</strong>
                      </div>
                    </div>
                    <br />
                    <input type="hidden" name="_token" :value="csrf" />

                    <div class="row" style="margin-bottom: 5px">
                      <div class="col-md-12">
                        <div class="form-group mb-0">
                          <label for="location">Select Town/County</label>
                          <Select2
                            id="town"
                            style="margin-top: 20px"
                            name="town"
                            placeholder="Please Select Your town"
                            v-model="form.town"
                            :options="towns"
                            :settings="{
                              settingOption: value,
                              settingOption: value,
                            }"
                            @change="townChangeEvent($event)"
                            @select="townSelectEvent($event)"
                          />

                          <div
                            class="text-red text-left smaller-text"
                            v-if="$page.props.errors.town"
                            v-text="$page.props.errors.town"
                          ></div>

                          <span
                            v-if="fetchingSubRegions == 1"
                            class="fa fa-spinner fa-spin"
                            style="color: black; font-size: 20px"
                          ></span>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <Select2
                            id="subRegion"
                            name="subRegion"
                            placeholder="Select Sub Region"
                            v-model="form.subRegion"
                            :options="subRegions"
                            :settings="{
                              settingOption: value,
                              settingOption: value,
                            }"
                            @change="subRegionChangeEvent($event)"
                            @select="subRegionSelectEvent($event)"
                          />
                        </div>

                        <div
                          class="text-red text-left smaller-text"
                          v-if="$page.props.errors.subRegion"
                          v-text="$page.props.errors.subRegion"
                        ></div>
                      </div>
                    </div>

                    <div class="form-group">
                      <input
                        type="text"
                        name="propertyTitle"
                        v-model="form.propertyTitle"
                      />
                      <label for="propertyTitle">Title</label>
                      <div
                        class="text-red text-left smaller-text"
                        v-if="$page.props.errors.propertyTitle"
                        v-text="$page.props.errors.propertyTitle"
                      ></div>
                    </div>

                    <div class="row mt-5">
                      <file-pond
                        :allowReorder="true"
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
                        class="btn btn-primary pull-right mb-5"
                      >
                        <strong
                          >Continue <i class="fa fa-arrow-right"></i
                        ></strong>
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
import Select2 from "vue3-select2-component";

import { Head } from "@inertiajs/inertia-vue3";

import axios from "axios";

import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

import FilePondPluginFilePoster from "filepond-plugin-file-poster";

import "filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css";

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
    property: Object,
  },
  components: { Select2, Head, FilePond },
  data() {
    return {
      ///filepnd
      myImages: [],
      //endfilepond
      //town: "",
      myOptions: ["op1", "op2", "op3"], // or [{id: key, text: value}, {id: key, text: value}]
      subRegions: [
        { id: this.defaultSubRegion.id, text: this.defaultSubRegion.text },
      ],
      subRegion: "",
      fetchingSubRegions: 0,
      csrf_token: $('meta[name="csrf-token"]').attr("content"),
      fileUploadEnable: true,
      form: useForm({
        town: this.property.town_id,
        subRegion: this.defaultSubRegion.id,
        propertyTitle: this.property.property_title,
        propertyID: this.property.id,
        images: "",
        step: "1",
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
    townSelectEvent({ id, text }) {
      this.fetchingSubRegions = 1;
      axios.get("/property/fetch-sub-locations/" + id).then((res) => {
        this.subRegions = res.data.data;
        this.fetchingSubRegions = 2;
        this.fileUploadEnable = false;
        //console.log(this.subRegions);
        // listData.value = res.data;
        // processing.value = true;
      });
    },

    submitForm() {
      this.form.post("/property/store", this.form, {
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
#town {
  margin-top: 20px !important;
}

.filepond--item {
  width: 100px !important;
  height: 90px !important;
  overflow: hidden;
}
</style>

