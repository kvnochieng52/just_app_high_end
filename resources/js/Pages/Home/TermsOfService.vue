 <template>
  <Head :title="title" />
  <section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header">
              <h4><strong>Terms of Service</strong></h4>
            </div>
            <div class="card-body">
              <p><strong>Effective Date:</strong> 01-January-2022</p>

              <p>
                Welcome to Just Homes! These Terms of Service govern your use of
                our website,
                <a href="https://justhomes.co.ke">justhomes.co.ke</a>, and the
                services we offer. By accessing or using our website, you agree
                to these terms. If you do not agree, please do not use our
                services.
              </p>

              <h4>1. Acceptance of Terms</h4>
              <p>
                By using Just Homes, you confirm that you are at least 18 years
                old and have the legal capacity to enter into these terms.
              </p>

              <h4>2. Services Offered</h4>
              <p>
                Just Homes provides a platform for real estate listings,
                including properties for sale and rent. We strive to provide
                accurate information but do not guarantee the accuracy or
                completeness of any listings.
              </p>

              <h4>3. User Accounts</h4>
              <p>
                You may need to create an account to access certain features of
                our website. You are responsible for maintaining the
                confidentiality of your account information and for all
                activities that occur under your account.
              </p>

              <h4>4. User Conduct</h4>
              <p>
                You agree not to use the website for any unlawful purposes or in
                a way that could damage, disable, or impair the website. You are
                prohibited from posting false or misleading information.
              </p>

              <h4>5. Intellectual Property</h4>
              <p>
                All content on Just Homes, including text, graphics, and logos,
                is the property of Just Homes or its licensors. You may not use
                any content without our express written consent.
              </p>

              <h4>6. Disclaimers</h4>
              <p>
                Just Homes does not endorse any properties listed on the site
                and is not responsible for any transactions between users and
                third parties. We do not guarantee the availability of any
                property listed.
              </p>

              <h4>7. Limitation of Liability</h4>
              <p>
                To the fullest extent permitted by law, Just Homes shall not be
                liable for any indirect, incidental, or consequential damages
                arising from your use of our website.
              </p>

              <h4>8. Modifications to Terms</h4>
              <p>
                We reserve the right to modify these terms at any time. Your
                continued use of the website after any changes constitutes your
                acceptance of the new terms.
              </p>

              <h4>9. Governing Law</h4>
              <p>
                These terms shall be governed by the laws of [insert applicable
                jurisdiction].
              </p>

              <h4>10. Contact Us</h4>
              <p>
                For any questions or concerns regarding these terms, please
                contact us at
                <a href="mailto:info@justhomes.co.ke">info@justhomes.co.ke</a>.
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

 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 