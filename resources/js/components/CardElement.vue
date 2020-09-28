<template>
  <div>
    <card
      class="stripe-card"
      :class="{ complete }"
      :stripe="stripe"
      :options="stripeOptions"
      @change="change($event)"
    />

    <!-- Used to display form errors -->
    <div id="card-errors" role="alert" v-text="errorMessage"></div>
  </div>
</template>

<script>
import { Card, createToken } from "vue-stripe-elements-plus";
export default {
  data() {
    return {
      stripe: Stripe(process.env.MIX_STRIPE_KEY),
      complete: false,
      errorMessage: "",
      stripeOptions: {
        style: {
          base: {
            color: "#32325d",
            lineHeight: "18px",
            fontFamily: '"Raleway", Helvetica, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
            "::placeholder": {
              color: "#aab7c4",
            },
          },
          invalid: {
            color: "#fa755a",
            iconColor: "#fa755a",
          },
        },
        hidePostalCode: true,
      },
    };
  },
  components: { Card },
  methods: {
    change(event) {
      this.errorMessage = event.error ? event.error.message : "";
    },
  },
  mounted() {
    this.stripe = process.env.MIX_STRIPE_KEY;
  },
};
</script>
