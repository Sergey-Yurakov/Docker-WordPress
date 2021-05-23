const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { RichText, PlainText } = wp.editor;
const { Button, TextControl, SelectControl, ServerSideRender } = wp.components;

registerBlockType('shop-page-wp/grid', {
  title: 'Shop Page WP',
  icon: 'cart',
  category: 'widgets',
  attributes: {
    grid: {
      type: 'string',
      selector: '.shop-page-wp-grid',
    },
    category: {
      type: 'string',
      selector: '.shop-page-wp-cats',
    },
    max_number: {
      type: 'string',
      selector: '.shop-page-wp-max-products',
    },
    product_ids: {
      type: 'string',
      selector: '.shop-page-wp-products-by-id',
    }
  },

  edit({ attributes, className, setAttributes }) {
    const { grid, category, max_number, product_ids } = attributes;

    function onChangegrid(newGrid) {
      setAttributes({ grid: newGrid });
    }

    function onChangeCats(newCats) {
      setAttributes({ category: newCats });
    }

    function onChangemax_number(newMaxNumber) {
      setAttributes({ max_number: newMaxNumber });
    }

    function onChangeProductIDs(newProductIDs) {
      setAttributes({ product_ids: newProductIDs });
    }

    return (
      <div className={className}>
        <h4>{__('Product Grid')} - Shop Page WP</h4>
        <SelectControl
          label={__('Number of Columns')}
          className="shop-page-wp-grid"
          value={grid}
          options={[
            { label: '1 Column', value: '1' },
            { label: '2 Columns', value: '2' },
            { label: '3 Columns', value: '3' },
            { label: '4 Columns', value: '4' },
          ]}
          onChange={onChangegrid}
        />
        <TextControl
          // label={ __("category (Separate multiple by pipe | symbol)") }
          label={__(
            'Categories (Separate multiple by pipe | symbol)  Leave Blank to Display All'
          )}
          className="shop-page-wp-cats"
          onChange={onChangeCats}
          type="text"
          value={category || ''}
        />
        <TextControl
          label={__('Max Number of Products to Display')}
          className="shop-page-wp-max-products"
          onChange={onChangemax_number}
          type="number"
          value={max_number || ''}
        />
        <TextControl
          label={__('Products by ID (Separate multiple by pipe | symbol - overrides Categories and Max Number)')}
          className="shop-page-wp-products-by-id"
          onChange={onChangeProductIDs}
          type="text"
          value={product_ids || ''}
        />
      </div>
    );
  },

  save({ attributes }) {
    const { grid, category, max_number } = attributes; // this is important?

    return null;
  },
});
