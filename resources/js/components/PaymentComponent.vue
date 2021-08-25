<template>
  <div class="card mt-5 col-md-8 col-12 mx-auto">
    <div class="card-header">Confirm</div>
    <div class="card-body">
      <div class="row row-cols-2" v-if="!response">
        <div class="col-md-6">
          <form class="">
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" v-model="owner">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" value="pepito.perez@example.com">
            </div>
            <div class="form-group" id="card-number-field"
              :class="{'is-invalid' : errors.length > 0}">
              <label>Card number</label>
              <input type="number" class="form-control" name="pan" v-model="pan">
              <ul class="list-group list-group-flush ms-2">
                <li v-for="(error, index) in errors" :key="index">
                  <ul class="list-group list-group-flush">
                    <li class="text-danger" v-for="(message, index) in error" :key="index">
                        {{ message }}
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
            <div class="container my-3"> 
              <h5>Amount: {{ totalPay }}</h5>
            </div>
          </form>
          <button type="button" class="btn btn-dark bottom-0 mt-5" 
              id="btnModal" @click="encrypt()"
              >Confirm</button>
        </div>
        <div class="col-md-6 mt-3 mt-md-0 px-auto">
          <div :id="div"></div>
          <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" v-model="owner">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" value="pepito.perez@example.com">
            </div>
        </div>
      </div>
      <div v-else class="container">
        <div class="card-title">Pinblock generated!</div>
        <p class="text-muted">{{ pinblock }}</p>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true" data-bs-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content border-0" id="content">
          <div class="modal-body">
            <div id="divModal"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PinPad from '@placetopay/pinpad-sdk'

export default {
  name: "PaymentComponent",
  props: {
    total: {
      type: Number,
      required: true,
      default: '0'
    }
  },
  data() {
    return {
      div: 'myDiv',
      pan: '',
      owner: 'Pepito Perez',
      pinpad: {},
      pin: '',
      response: false,
      pinblock: '',
      modal: {},
      errors: () => { return []},
      onSuccess: (res) => { 
        this.response = true
        this.pinblock = res.data.pinblock
        this.modal.hide()
      },
      onError: (err) => {
        this.errors = err.response.data.errors
        this.modal.hide()
      },
      onClean: () => {
        console.log('on clean ok');
      }
    };
  },
  computed: {
    totalPay() {
      return this.numberFormatter(this.total)
    }
  },
  watch: {
    pan () {
      this.errors = []
      this.pinpad.config.pan = this.pan
    }
  },
  methods: {
    numberFormatter: function (number) {
      const val = new Intl.NumberFormat('es').format(number)
      return `$ ${val}`
    },
    encrypt () {
      this.pinpad.encryptPin().then(res => {
        console.log(res.data)
      }).catch(e => {
        console.log(e.response.data)
      })
    }
  },
  mounted () {
    this.pinpad = new PinPad({
      url: 'http://pinpad.test',
      token: '24|ZcvXlhAGvXau9zmTwBh0IoiyHHg8ulVsUr7WJsNK',
      locale: 'es',
      format: 0
      // pinLength: 4
    })
    // this.pinpad.render('divModal', this.pan, this.onSuccess, this.onError)
    this.pinpad.render(this.div, this.pan, ()=>{}, () => {console.log('back');})
    // eslint-disable-next-line no-undef
    this.modal = new bootstrap.Modal(document.getElementById('exampleModal'))
  },
};
</script>

<style>
/* #myDiv {
  margin: 30px;
} */
/* .card-pinpad{
  padding: 3rem;
  background-color: white;
  box-shadow: black;
} */
</style>