import { on, off } from 'utils/mixins';

const ComponentView = require('./ComponentView');

module.exports = ComponentView.extend({
  events: {
    dblclick: 'onActive',
    input: 'onInput'
  },

  initialize(o) {
    ComponentView.prototype.initialize.apply(this, arguments);
    this.disableEditing = this.disableEditing.bind(this);
    const model = this.model;
    const em = this.em;
    this.listenTo(model, 'focus', this.onActive);
    this.listenTo(model, 'change:content', this.updateContentText);
    this.rte = em && em.get('RichTextEditor');
  },

  updateContentText(m, v, opts = {}) {
    !opts.fromDisable && this.disableEditing();
  },

  /**
   * Enable element content editing
   * @private
   * */
  onActive(e) {
    // We place this before stopPropagation in case of nested
    // text components will not block the editing (#1394)
    if (this.rteEnabled || !this.model.get('editable')) {
      return;
    }
    e && e.stopPropagation && e.stopPropagation();
    const rte = this.rte;

    if (rte) {
      try {
        this.activeRte = rte.enable(this, this.activeRte);
      } catch (err) {
        console.error(err);
      }
    }

    this.rteEnabled = 1;
    this.toggleEvents(1);
  },

  /**
   * Disable element content editing
   * @private
   * */
  disableEditing() {
    const model = this.model;
    const editable = model.get('editable');
    const rte = this.rte;
    const contentOpt = { fromDisable: 1 };

    if (rte && editable) {
      try {
        rte.disable(this, this.activeRte);
      } catch (err) {
        console.error(err);
      }

      const content = this.getChildrenContainer().innerHTML;
      const comps = model.get('components');
      comps.length && comps.reset();
      model.set('content', '', contentOpt);

      // If there is a custom RTE the content is just baked staticly
      // inside 'content'
      if (rte.customRte) {
        // Avoid double content by removing its children components
        // and force to trigger change
        model.set('content', content, contentOpt);
      } else {
        const clean = model => {
          const selectable = !['text', 'default', ''].some(type =>
            model.is(type)
          );
          model.set({
            editable: selectable && model.get('editable'),
            highlightable: 0,
            removable: 0,
            draggable: 0,
            copyable: 0,
            selectable: selectable,
            hoverable: selectable,
            toolbar: ''
          });
          model.get('components').each(model => clean(model));
        };

        // Avoid re-render on reset with silent option
        model.trigger('change:content', model, '', contentOpt);
        comps.add(content);
        comps.each(model => clean(model));
        comps.trigger('resetNavigator');
      }
    }

    this.rteEnabled = 0;
    this.toggleEvents();
  },

  /**
   * Callback on input event
   * @param  {Event} e
   */
  onInput(e) {
    const { em } = this;

    // Update toolbars
    em && em.trigger('change:canvasOffset');
  },

  /**
   * Isolate disable propagation method
   * @param {Event}
   * @private
   * */
  disablePropagation(e) {
    e.stopPropagation();
  },

  /**
   * Enable/Disable events
   * @param {Boolean} enable
   */
  toggleEvents(enable) {
    var method = enable ? 'on' : 'off';
    const mixins = { on, off };
    this.em.setEditing(enable);

    // The ownerDocument is from the frame
    var elDocs = [this.el.ownerDocument, document];
    mixins.off(elDocs, 'mousedown', this.disableEditing);
    mixins[method](elDocs, 'mousedown', this.disableEditing);

    // Avoid closing edit mode on component click
    this.$el.off('mousedown', this.disablePropagation);
    this.$el[method]('mousedown', this.disablePropagation);
  }
});
