wp.domReady(function () {
  /** remove block gutenberg */
  var enabledEmbeds = ['youtube']

  var embedBlock = wp.blocks.getBlockVariations('core/embed')
  if (embedBlock) {
    embedBlock.forEach(function (el) {
      if (!enabledEmbeds.includes(el.name)) {
        wp.blocks.unregisterBlockVariation('core/embed', el.name)
      }
    })
  }
})
