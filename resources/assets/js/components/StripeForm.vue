<template>
  <form :action="action" method="POST">
    <input type="hidden" name="_token" :value="csrf">
    <stripe-checkout
      button="Suscribirme"
      buttonClass="btn btn-course"
      :stripe-key="stripe_key"
      :product="product"
    ></stripe-checkout>
  </form>
</template>

<script>
import { StripeCheckout } from "vue-stripe";
export default {
  components: {
    StripeCheckout
  },
  mounted() {
    this.csrf = document.head.querySelector('meta[name="csrf-token"]').content;
  },
  data() {
    return {
      // csrf: document.head.querySelector('meta[name="csrf-token"]').content
      csrf: ""
    };
  },
  props: {
    stripe_key: "",
    name: "",
    amount: "",
    description: "",
    action: "",
    scrf: ""
  },
  computed: {
    product() {
      return {
        name: this.name,
        amount: parseFloat(this.amount),
        description: this.description
      };
    }
  }
};
</script>

