<template>
  <!-- Modal -->
  <div class="modal fade" id="product-modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="label-product-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <img :src="imagePath + product.image" class="card-img-top img-product-detail" alt="...">
        <div class="modal-body">
          <table class="table table-borderless">
            <thead>
            <tr>
              <th>Name:</th>
              <td id="productName">{{ product.name }}</td>
            </tr>
            <tr>
              <th>Reference:</th>
              <td id="productReference">{{ product.reference }}</td>
            </tr>
            <tr>
              <th>Description:</th>
              <td id="productDescription">{{ product.description }}</td>
            </tr>
            <tr>
              <th>Stock:</th>
              <td id="productStock">{{ product.stock }}</td>
            </tr>
            <tr>
              <th>Price:</th>
              <td id="productPrice">{{ product.price }}</td>
            </tr>
            </thead>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProductModalComponent',

  data () {
    return {
      product: {
        name: '',
        reference: '',
        description: '',
        stock: 0,
        price: 0,
        image: 'default.png'
      },
      imagePath: window.imagePath
    }
  },

  mounted () {
    let self = this
    window.EventBus.$on('product', function (product) {
      self.product = product
    })
  }
}
</script>
