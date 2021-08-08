<template>
    <div class="form-group">
        <div class="form-group">
            <slot></slot>
        </div>
    </div>
</template>

<script>

export default {
    name:"card-option",
    props: {
      isLast: {
          type: Boolean,
          required: true
      },
    },
    }
</script>
