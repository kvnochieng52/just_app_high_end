<template>
  <Head :title="title" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header">
              <h4><strong>Deactivate/Delete Account</strong></h4>
            </div>
            <div class="card-body">
              <h5><strong>Deactivate Account:</strong></h5>
              <p>
                This will make your account inactive and won't be accessible. If
                you need to deactivate your account, please follow the steps
                below:
              </p>
              <ol class="numbered-list">
                <li>Login to your Android/IOS app</li>
                <li>Tap on the Dashboard button</li>
                <li>Under Profile Section, Tap on Deactivate Account</li>
                <li>Tap on Deactivate Account</li>
                <li>Accept the Prompt by clicking on the Proceed Button</li>
              </ol>
              <p>
                Your account will be deactivated. If you need your account
                activated again, please contact us through our
                <a href="/contact-us" target="_blank"
                  >Contact Details page (Click here)</a
                >.
              </p>
              <h5><strong>Delete Account:</strong></h5>
              <p>
                Deleting your account involves deleting all your details
                associated with Just Homes, including your profile, all the
                properties you have posted, your statistical data, leads, and
                appointments. Please proceed with caution.
              </p>
              <p>To delete your account:</p>
              <ol class="numbered-list">
                <li>Login to your Android/IOS app</li>
                <li>Tap on the Dashboard button</li>
                <li>Under Profile Section, Tap on Deactivate Account</li>
                <li>Tap on Delete Account</li>
                <li>Accept the Prompt by clicking on the Proceed Button</li>
              </ol>
              <p>
                For more information, please contact us through our
                <a href="/contact-us" target="_blank"
                  >Contact Details page (Click here)</a
                >.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Head } from "@inertiajs/inertia-vue3";

defineProps({
  Categories: Array,
});

let title = "Deactivate/Delete Account";
let form = reactive({
  category: "",
  keywords: "",
});

let submitSearchForm = () => {
  Inertia.get("/product/search", form);
};
</script>

<style scoped>
.numbered-list {
  list-style-type: decimal;
  padding-left: 20px;
  margin: 10px 0;
}
</style>
