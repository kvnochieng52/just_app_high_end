<template>
  <Head :title="title" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header">
              <h4><strong>Privacy Policy</strong></h4>
            </div>
            <div class="card-body">
              <h4><strong>Introduction</strong></h4>
              <p>
                Welcome to Just Homes. We value your privacy and are committed
                to protecting your personal information. This Privacy Policy
                explains how we collect, use, disclose, and safeguard your
                information when you use our mobile application and services.
              </p>

              <h4><strong>Information We Collect</strong></h4>
              <p>
                When you use Just Homes, we may collect the following types of
                information:
              </p>
              <ul>
                <li>
                  <strong>Personal Information:</strong> Name, email address,
                  phone number, and other contact details you provide.
                </li>
                <!-- <li>
                  <strong>Usage Data:</strong> Information about how you
                  interact with our app, including your IP address, device
                  information, and browsing activity.
                </li>
                <li>
                  <strong>Location Data:</strong> If you enable location
                  services, we may collect information about your geographic
                  location.
                </li> -->
              </ul>

              <h4><strong>How We Use Your Information</strong></h4>
              <p>We use the information we collect to:</p>
              <ul>
                <li>Provide and maintain our services.</li>
                <li>Respond to your inquiries and provide customer support.</li>
                <li>Improve our app and services.</li>
                <li>
                  Send you notifications and updates related to your use of the
                  app.
                </li>
              </ul>

              <h4><strong>Sharing Your Information</strong></h4>
              <p>
                We do not share your personal information with third parties
                except in the following circumstances:
              </p>
              <ul>
                <li>With your consent.</li>
                <li>
                  To comply with legal obligations or to protect and defend our
                  rights and property.
                </li>
                <li>
                  With service providers who assist us in operating our app and
                  providing services to you, provided they are bound by
                  confidentiality agreements.
                </li>
              </ul>

              <h4><strong>Your Choices</strong></h4>
              <p>You have the following choices regarding your information:</p>
              <ul>
                <li>
                  You can update or correct your personal information through
                  the app.
                </li>
                <li>
                  You can opt out of receiving marketing communications from us
                  by following the instructions in those communications.
                </li>
              </ul>

              <h4><strong>Data Security</strong></h4>
              <p>
                We implement reasonable security measures to protect your
                information from unauthorized access, use, or disclosure.
                However, no method of transmission over the internet or
                electronic storage is completely secure, so we cannot guarantee
                absolute security.
              </p>

              <h4><strong>Children’s Privacy</strong></h4>
              <p>
                Our app is not intended for use by children under the age of 13.
                We do not knowingly collect personal information from children
                under 13. If we become aware that we have collected such
                information, we will take steps to delete it.
              </p>

              <h4><strong>Changes to This Privacy Policy</strong></h4>
              <p>
                We may update this Privacy Policy from time to time. We will
                notify you of any significant changes by posting the new Privacy
                Policy on our website and updating the effective date at the
                top.
              </p>

              <h4><strong>Contact Us</strong></h4>
              <p>
                If you have any questions or concerns about this Privacy Policy,
                please contact us at:
              </p>
              <p>
                Email:
                <a href="mailto:support@justhomesapp.com"
                  >support@justhomesapp.com</a
                >
              </p>
              <p>
                Website: <a href="https://justhomes.co.ke">justhomes.co.ke</a>
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

let title = "Privacy Policy";
let form = reactive({
  category: "",
  keywords: "",
});

let submitSearchForm = () => {
  Inertia.get("/product/search", form);
};
</script>
