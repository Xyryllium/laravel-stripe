<template>
  <div>
    <form
      action="/checkout"
      method="POST"
      id="payment-form"
      @submit.prevent="pay()"
      ref="form"
    >
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" class="form-control" id="email" />
      </div>

      <div class="form-group">
        <label for="name_on_card">Name on Card</label>
        <input
          type="text"
          class="form-control"
          id="name_on_card"
          name="name_on_card"
          v-model="name_on_card"
        />
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="address">Address</label>
            <input
              type="text"
              class="form-control"
              id="address"
              name="address"
            />
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city" />
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="province">Province</label>
            <input
              type="text"
              class="form-control"
              id="province"
              name="province"
            />
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="postalcode">Postal Code</label>
            <input
              type="text"
              class="form-control"
              id="postalcode"
              name="postalcode"
            />
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label for="country">Country</label>
            <input
              type="text"
              class="form-control"
              id="country"
              name="country"
            />
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="card-element">Credit Card</label>
        <card-element></card-element>
      </div>

      <input type="hidden" name="_token" :value="csrf" />

      <div class="spacer"></div>

      <button type="submit" class="btn btn-success">Submit Payment</button>
    </form>
  </div>
</template>

<script>
import { createToken } from "vue-stripe-elements-plus";
export default {
  data() {
    return {
      csrf: document.querySelector('meta[name="csrf-token"]').content,
      name_on_card: "",
    };
  },
  methods: {
    pay() {
      const options = {
        name: this.name_on_card,
      };
      createToken(options).then((result) => {
        var hiddenInput = document.createElement("input");
        hiddenInput.setAttribute("type", "hidden");
        hiddenInput.setAttribute("name", "stripeToken");
        hiddenInput.setAttribute("value", result.token.id);

        this.$refs.form.appendChild(hiddenInput);

        // Submit the form
        this.$refs.form.submit();
      });
    },
  },
};
</script>
