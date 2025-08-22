<template>
  <Head :title="title" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <!-- Contact Details -->
        <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-header">
              <h4><strong>Contact Details</strong></h4>
            </div>
            <div class="card-body">
              <ul class="list-unstyled">
                <li class="mb-3">
                  <strong>Email:</strong><br />
                  <a href="mailto:support@justhomesapp.com"
                    >support@justhomesapp.com</a
                  >
                </li>
                <li class="mb-3">
                  <strong>Telephone/WhatsApp:</strong> <br />
                  <a href="tel:+254757888000">+254 757 888000</a>
                </li>
                <li class="mb-3">
                  <strong>Location:</strong><br />
                  Oneleven Building, Ngong, Kenya
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-header">
              <h4><strong>Contact Us</strong></h4>
            </div>
            <div class="card-body">
              <form @submit.prevent="submitContactForm">
                <div class="form-group mb-3">
                  <label for="name">Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    v-model="form.name"
                    placeholder="Your Name"
                    required
                  />
                </div>

                <div class="form-group mb-3">
                  <label for="name">Telephone(optional)</label>
                  <input
                    type="text"
                    class="form-control"
                    id="telephone"
                    v-model="form.telephone"
                    placeholder="Your telephone"
                  />
                </div>
                <div class="form-group mb-3">
                  <label for="email">Email</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    v-model="form.email"
                    placeholder="Your Email"
                    required
                  />
                </div>
                <div class="form-group mb-3">
                  <label for="message">Message</label>
                  <textarea
                    class="form-control"
                    id="message"
                    v-model="form.message"
                    placeholder="Your Message"
                    rows="5"
                    required
                  ></textarea>
                </div>
                <button type="submit" class="btn btn-success w-100">
                  Send Message
                </button>
              </form>
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

let title = "Contact Us";
let form = reactive({
  name: "",
  email: "",
  message: "",
  telephone: "",
});

let submitContactForm = () => {
  // Handle the form submission
  Inertia.post("/contact-submit", form);
};
</script>
