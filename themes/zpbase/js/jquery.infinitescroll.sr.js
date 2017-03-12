/*
    --------------------------------
    Infinite Scroll Behavior
    Simply Recipes Mobile Style
    : First scroll requires manual trigger, then switch to auto
    --------------------------------
    by Jesse Gardner, http://plasticmind.com

*/

$.extend($.infinitescroll.prototype,{
    _setup_simplyrecipes: function infscr_setup_simplyrecipes () {
        var instance = this;
        var opts = this.options;

        this._binding('bind');
        this._numScrolls = 0; // Register a scroll counter

        this.options.loading.start = function (opts) {
            if(instance._numScrolls==0) { // First scroll requires manual trigger
                $(opts.navSelector).show();
                $(opts.nextSelector).bind('click', function(e) {
                    e.preventDefault();
                    $(opts.navSelector).fadeOut('fast');
                    opts.loading.msg.appendTo(opts.loading.selector).fadeIn('fast');
                    instance.beginAjax(opts);
                });
            } else { // All scrolls after that happens automatically
                $(opts.navSelector).hide();
                opts.loading.msg.appendTo(opts.loading.selector).show(opts.loading.speed);
                instance.beginAjax(opts);
            }
        }
        this.options.loading.finished = function() {
            opts.loading.msg.fadeOut('fast');
            instance._numScrolls++;
        }
        return false;
    }
});