var AjaxStarter = function (url, callback) {

    this.url = url;

    this.callback = callback || function () {
        console.log(this.procents)
    };

    this.page = 1;

    this.pagesNum = 1;

    this.procents = 0;

}


AjaxStarter.prototype.request = function () {

    var self = this;

    var dt = new Date();

    $.getJSON(this.url, {page: this.page, time: dt.getTime()}, function (data) {

        if (!data.errors) {

            self.page++;

            self.data = data;

            self.page = data.page;

            self.pagesNum = data.pagesNum;

            self.procents = (self.page / self.pagesNum) * 100;

            self.callback.apply(self);

            if (self.page <= self.pagesNum)
                self.request();
            else
                self.page = 1;

        } else {

            self.errors = data.errors;

            self.callback.apply(self);

        }


    });

}