/**
 * Export Plugin for DataTables.
 * 2016 Dida Nurwanda - www.didanurwanda.com
 */

(function($) {

    /**
     * SaveAs function source from HTML5 export buttons  
     * 2015 SpryMedia Ltd - datatables.net/license
     * 
     * FileSaver.js (2015-05-07.2) - MIT license
     * Copyright © 2015 Eli Grey - http://eligrey.com 
     */
    var saveAs = (function(view) {
        // IE <10 is explicitly unsupported
        if (typeof navigator !== "undefined" && /MSIE [1-9]\./.test(navigator.userAgent)) {
            return;
        }
        var doc = view.document
            // only get URL when necessary in case Blob.js hasn't overridden it yet
            ,
            get_URL = function() {
                return view.URL || view.webkitURL || view;
            },
            save_link = doc.createElementNS("http://www.w3.org/1999/xhtml", "a"),
            can_use_save_link = "download" in save_link,
            click = function(node) {
                var event = doc.createEvent("MouseEvents");
                event.initMouseEvent("click", true, false, view, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
                node.dispatchEvent(event);
            },
            webkit_req_fs = view.webkitRequestFileSystem,
            req_fs = view.requestFileSystem || webkit_req_fs || view.mozRequestFileSystem,
            throw_outside = function(ex) {
                (view.setImmediate || view.setTimeout)(function() {
                    throw ex;
                }, 0);
            },
            force_saveable_type = "application/octet-stream",
            fs_min_size = 0
            // See https://code.google.com/p/chromium/issues/detail?id=375297#c7 and
            // https://github.com/eligrey/FileSaver.js/commit/485930a#commitcomment-8768047
            // for the reasoning behind the timeout and revocation flow
            ,
            arbitrary_revoke_timeout = 500 // in ms
            ,
            revoke = function(file) {
                var revoker = function() {
                    if (typeof file === "string") { // file is an object URL
                        get_URL().revokeObjectURL(file);
                    } else { // file is a File
                        file.remove();
                    }
                };
                if (view.chrome) {
                    revoker();
                } else {
                    setTimeout(revoker, arbitrary_revoke_timeout);
                }
            },
            dispatch = function(filesaver, event_types, event) {
                event_types = [].concat(event_types);
                var i = event_types.length;
                while (i--) {
                    var listener = filesaver["on" + event_types[i]];
                    if (typeof listener === "function") {
                        try {
                            listener.call(filesaver, event || filesaver);
                        } catch (ex) {
                            throw_outside(ex);
                        }
                    }
                }
            },
            auto_bom = function(blob) {
                // prepend BOM for UTF-8 XML and text/* types (including HTML)
                if (/^\s*(?:text\/\S*|application\/xml|\S*\/\S*\+xml)\s*;.*charset\s*=\s*utf-8/i.test(blob.type)) {
                    return new Blob(["\ufeff", blob], {
                        type: blob.type
                    });
                }
                return blob;
            },
            FileSaver = function(blob, name) {
                blob = auto_bom(blob);
                // First try a.download, then web filesystem, then object URLs
                var filesaver = this,
                    type = blob.type,
                    blob_changed = false,
                    object_url, target_view, dispatch_all = function() {
                        dispatch(filesaver, "writestart progress write writeend".split(" "));
                    }
                    // on any filesys errors revert to saving with object URLs
                    ,
                    fs_error = function() {
                        // don't create more object URLs than needed
                        if (blob_changed || !object_url) {
                            object_url = get_URL().createObjectURL(blob);
                        }
                        if (target_view) {
                            target_view.location.href = object_url;
                        } else {
                            var new_tab = view.open(object_url, "_blank");
                            if (new_tab === undefined && typeof safari !== "undefined") {
                                //Apple do not allow window.open, see http://bit.ly/1kZffRI
                                view.location.href = object_url;
                            }
                        }
                        filesaver.readyState = filesaver.DONE;
                        dispatch_all();
                        revoke(object_url);
                    },
                    abortable = function(func) {
                        return function() {
                            if (filesaver.readyState !== filesaver.DONE) {
                                return func.apply(this, arguments);
                            }
                        };
                    },
                    create_if_not_found = {
                        create: true,
                        exclusive: false
                    },
                    slice;
                filesaver.readyState = filesaver.INIT;
                if (!name) {
                    name = "download";
                }
                if (can_use_save_link) {
                    object_url = get_URL().createObjectURL(blob);
                    save_link.href = object_url;
                    save_link.download = name;
                    click(save_link);
                    filesaver.readyState = filesaver.DONE;
                    dispatch_all();
                    revoke(object_url);
                    return;
                }
                // Object and web filesystem URLs have a problem saving in Google Chrome when
                // viewed in a tab, so I force save with application/octet-stream
                // http://code.google.com/p/chromium/issues/detail?id=91158
                // Update: Google errantly closed 91158, I submitted it again:
                // https://code.google.com/p/chromium/issues/detail?id=389642
                if (view.chrome && type && type !== force_saveable_type) {
                    slice = blob.slice || blob.webkitSlice;
                    blob = slice.call(blob, 0, blob.size, force_saveable_type);
                    blob_changed = true;
                }
                // Since I can't be sure that the guessed media type will trigger a download
                // in WebKit, I append .download to the filename.
                // https://bugs.webkit.org/show_bug.cgi?id=65440
                if (webkit_req_fs && name !== "download") {
                    name += ".download";
                }
                if (type === force_saveable_type || webkit_req_fs) {
                    target_view = view;
                }
                if (!req_fs) {
                    fs_error();
                    return;
                }
                fs_min_size += blob.size;
                req_fs(view.TEMPORARY, fs_min_size, abortable(function(fs) {
                    fs.root.getDirectory("saved", create_if_not_found, abortable(function(dir) {
                        var save = function() {
                            dir.getFile(name, create_if_not_found, abortable(function(file) {
                                file.createWriter(abortable(function(writer) {
                                    writer.onwriteend = function(event) {
                                        target_view.location.href = file.toURL();
                                        filesaver.readyState = filesaver.DONE;
                                        dispatch(filesaver, "writeend", event);
                                        revoke(file);
                                    };
                                    writer.onerror = function() {
                                        var error = writer.error;
                                        if (error.code !== error.ABORT_ERR) {
                                            fs_error();
                                        }
                                    };
                                    "writestart progress write abort".split(" ").forEach(function(event) {
                                        writer["on" + event] = filesaver["on" + event];
                                    });
                                    writer.write(blob);
                                    filesaver.abort = function() {
                                        writer.abort();
                                        filesaver.readyState = filesaver.DONE;
                                    };
                                    filesaver.readyState = filesaver.WRITING;
                                }), fs_error);
                            }), fs_error);
                        };
                        dir.getFile(name, {
                            create: false
                        }, abortable(function(file) {
                            // delete file if it already exists
                            file.remove();
                            save();
                        }), abortable(function(ex) {
                            if (ex.code === ex.NOT_FOUND_ERR) {
                                save();
                            } else {
                                fs_error();
                            }
                        }));
                    }), fs_error);
                }), fs_error);
            },
            FS_proto = FileSaver.prototype,
            saveAs = function(blob, name) {
                return new FileSaver(blob, name);
            };
        // IE 10+ (native saveAs)
        if (typeof navigator !== "undefined" && navigator.msSaveOrOpenBlob) {
            return function(blob, name) {
                return navigator.msSaveOrOpenBlob(auto_bom(blob), name);
            };
        }
        FS_proto.abort = function() {
            var filesaver = this;
            filesaver.readyState = filesaver.DONE;
            dispatch(filesaver, "abort");
        };
        FS_proto.readyState = FS_proto.INIT = 0;
        FS_proto.WRITING = 1;
        FS_proto.DONE = 2;
        FS_proto.error = FS_proto.onwritestart = FS_proto.onprogress = FS_proto.onwrite = FS_proto.onabort = FS_proto.onerror = FS_proto.onwriteend = null;
        return saveAs;
    }(window));
    var isSafari = function() {
        return navigator.userAgent.indexOf('Safari') !== -1 && navigator.userAgent.indexOf('Chrome') === -1 && navigator.userAgent.indexOf('Opera') === -1;
    };
    var link = document.createElement('a');
    var relToAbs = function(el) {
        var url;
        var clone = $(el).clone()[0];
        var linkHost;
        if (clone.nodeName.toLowerCase() === 'link') {
            link.href = clone.href;
            linkHost = link.host;
            // IE doesn't have a trailing slash on the host
            // Chrome has it on the pathname
            if (linkHost.indexOf('/') === -1 && link.pathname.indexOf('/') !== 0) {
                linkHost += '/';
            }
            clone.href = link.protocol + "//" + linkHost + link.pathname + link.search;
        }
        return clone.outerHTML;
    };
    $.fn.DataTable.Export = {
        word: function(dt, config) {
            var settings = {
                fields: [],
                header: [],
                orientation: 'potrait',
                title: '',
                message: '',
                filename: 'document',
                charset: ''
            };
            $.extend(true, settings, config);
            var _data = dt.rows().data();
            var templateHeader = '<html xmlns:v="urn:schemas-microsoft-com:vml"\
xmlns:o="urn:schemas-microsoft-com:office:office"\
xmlns:w="urn:schemas-microsoft-com:office:word"\
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"\
xmlns:css="http://macVmlSchemaUri" xmlns="http://www.w3.org/TR/REC-html40">\
<head>\
<meta name=Title content="">\
<meta name=Keywords content="">\
<meta http-equiv=Content-Type content="text/html; charset=unicode">\
<meta name=ProgId content=Word.Document>\
<meta name=Generator content="Microsoft Word 14">\
<meta name=Originator content="Microsoft Word 14">\
<link rel=File-List href="Customer%20(5)_files/filelist.xml">\
<!--[if gte mso 9]><xml>\
 <w:WordDocument>\
  <w:View>Print</w:View>\
 </w:WordDocument>\
</xml><![endif]-->\
<style>';
            if (settings.orientation == 'potrait') {
                templateHeader += '<!--@page WORDSECTION1 {mso-page-orientation:potrait;} -->';
            } else {
                templateHeader += '<!--@page WordSection1 {size:792.0pt 612.0pt; mso-page-orientation:landscape; margin:90.0pt 72.0pt 90.0pt 72.0pt; mso-header-margin:35.4pt; mso-footer-margin:35.4pt; mso-paper-source:0;}div.WordSection1 {page:WordSection1;}-->';
            }
            templateHeader += '</style></head><body bgcolor=white lang=EN-US style=\'tab-interval:36.0pt\'><div class=WordSection1>';
            var templateFooter = '<p class=MsoNormal style=\'mso-margin-top-alt:auto;mso-margin-bottom-alt:auto\'><span style=\'mso-fareast-font-family:"Times New Roman";mso-bidi-font-family:"Times New Roman"\'><o:p>&nbsp;</o:p></span></p></div></body></html>';
            var thead = '<thead>';
            thead += '<tr>';
            for (var i in settings.header) {
                thead += '<th>' + settings.header[i] + '</th>';
            }
            thead += '</tr>';
            thead += '</thead>';
            var tbody = '<tbody>';
            for (var i = 0; i < _data.length; i++) {
                var row = _data[i];
                var tr = '<tr>';
                for (var fieldIndex in settings.fields) {
                    var field = settings.fields[fieldIndex];
                    tr += '<td>' + (row[field] == null ? '' : row[field]) + '</td>';
                }
                tr += "</tr>\n";
                tbody += tr;
            }
            tbody += '</tbody>';
            var output = '';
            if (settings.title != '') {
                output += '<center><h1>' + settings.title + '</h1></center>';
            }
            if (settings.message != '') {
                output += '<center><p>' + settings.message + '</p></center>';
            }
            output += '<table border="1" width="100%">';
            if (settings.header.length > 0) {
                output += thead;
            }
            output += tbody;
            output += '</table>';

            var charset = '';
            if (settings.charset != '') {
                charset = settings.charset;
            } else {
                charset = document.characterSet || document.charset;
            }

            saveAs(new Blob(["\ufeff", templateHeader + output + templateFooter], {
                type: 'application/msword;charset='+ charset,
                encoding: charset
            }), settings.filename + '.doc');
        },
        excel: function(dt, config) {
            var settings = {
                fields: [],
                header: [],
                title: '',
                message: '',
                filename: 'document',
                charset: ''
            };
            $.extend(true, settings, config);
            var _data = dt.rows().data();
            var thead = '<thead>';
            thead += '<tr>';
            for (var i in settings.header) {
                thead += '<th>' + settings.header[i] + '</th>';
            }
            thead += '</tr>';
            thead += '</thead>';
            var tbody = '<tbody>';
            for (var i = 0; i < _data.length; i++) {
                var row = _data[i];
                var tr = '<tr>';
                for (var fieldIndex in settings.fields) {
                    var field = settings.fields[fieldIndex];
                    tr += '<td>' + (row[field] == null ? '' : row[field]) + '</td>';
                }
                tr += "</tr>\n";
                tbody += tr;
            }
            tbody += '</tbody>';
            var output = '';
            if (settings.title != '') {
                output += '<center><h1>' + settings.title + '</h1></center>';
            }
            if (settings.message != '') {
                output += '<center><p>' + settings.message + '</p></center>';
            }
            output += '<table border="1" width="100%">';
            if (settings.header.length > 0) {
                output += thead;
            }
            output += tbody;
            output += '</table>';

            var charset = '';
            if (settings.charset != '') {
                charset = settings.charset;
            } else {
                charset = document.characterSet || document.charset;
            }

            saveAs(new Blob(["\ufeff", output], {
                type: 'application/msexcel;charset='+ charset,
                encoding: charset
            }), settings.filename + '.xls');
        },
        csv: function(dt, config) {
            var settings = {
                fields: [],
                header: [],
                separator: ',',
                title: '',
                message: '',
                filename: 'document',
                charset: ''
            };
            $.extend(true, settings, config);
            var _data = dt.rows().data();
            var thead = "";
            for (var i in settings.header) {
                thead += settings.header[i] + settings.separator;
            }
            thead += "\n";
            var tbody = "";
            for (var i = 0; i < _data.length; i++) {
                var row = _data[i];
                for (var fieldIndex in settings.fields) {
                    var field = settings.fields[fieldIndex];
                    tbody += (row[field] == null ? '' : row[field]) + settings.separator;
                }
                tbody += "\n";
            }
            var output = "";
            if (settings.title != '') {
            //    output += settings.title += "\n";
            }
            if (settings.message != '') {
            //    output += settings.message += "\n";
            }
            if (settings.header.length > 0) {
                output += thead;
            }
            output += tbody;

            var charset = '';
            if (settings.charset != '') {
                charset = settings.charset;
            } else {
                charset = document.characterSet || document.charset;
            }

            saveAs(new Blob(["\ufeff", output], {
                type: 'text/csv;charset='+ charset,
                encoding: charset
            }), settings.filename + '.csv');
        },
        pdf: function(dt, config) {
            var settings = {
                fields: [],
                header: [],
                footer: [],
                filename: 'document',
                orientation: 'portrait',
                pageSize: 'A4',
                title: '',
                message: '',
                download: 'download',
                charset: ''
            };
            $.extend(true, settings, config);
            var _data = dt.rows().data();
            var rows = [];
            if (settings.header.length > 0) {
                var dataRow = [];
                for (var i in settings.header) {
                    dataRow.push({
                        text: settings.header[i],
                        style: 'tableHeader'
                    });
                }
                rows.push(dataRow);
            }
            for (var i = 0; i < _data.length; i++) {
                var item = _data[i];
                var dataRow = [];
                for (var fieldIndex in settings.fields) {
                    var field = settings.fields[fieldIndex];
                    dataRow.push({
                        text: item[field] == null ? '' : item[field],
                        style: i % 2 ? 'tableBodyEven' : 'tableBodyOdd'
                    });
                }
                rows.push(dataRow);
            }
            if (settings.footer.length > 0) {
                var dataRow = [];
                for (var i in settings.header) {
                    dataRow.push({
                        text: settings.header[i],
                        style: 'tableFooter'
                    });
                }
                rows.push(dataRow);
            }
            var doc = {
                pageSize: config.pageSize,
                pageOrientation: config.orientation,
                content: [{
                    table: {
                        headerRows: 1,
                        body: rows
                    },
                    layout: 'noBorders'
                }],
                styles: {
                    tableHeader: {
                        bold: true,
                        fontSize: 11,
                        color: 'white',
                        fillColor: '#2d4154',
                        alignment: 'center'
                    },
                    tableBodyEven: {},
                    tableBodyOdd: {
                        fillColor: '#f3f3f3'
                    },
                    tableFooter: {
                        bold: true,
                        fontSize: 11,
                        color: 'white',
                        fillColor: '#2d4154'
                    },
                    title: {
                        alignment: 'center',
                        fontSize: 15
                    },
                    message: {
                        alignment: 'center',
                    }
                },
                defaultStyle: {
                    fontSize: 10
                }
            };
            if (settings.message != '') {
                doc.content.unshift({
                    text: settings.message,
                    style: 'message',
                    margin: [0, 0, 0, 12]
                });
            }
            if (settings.title != '') {
                doc.content.unshift({
                    text: settings.title,
                    style: 'title',
                    margin: [0, 0, 0, 12]
                });
            }
            
            var charset = '';
            if (settings.charset != '') {
                charset = settings.charset;
            } else {
                charset = document.characterSet || document.charset;
            }

            var pdf = window.pdfMake.createPdf(doc);
            if (config.download === 'open' && !isSafari()) {
                pdf.open();
            } else {
                pdf.getBuffer(function(buffer) {
                    var blob = new Blob(["\ufeff", buffer], {
                        type: 'application/pdf;charset='+ charset,
                        encoding: charset
                    });
                    saveAs(blob, settings.filename + '.pdf');
                });
            }
        },
        html: function(dt, config) {
            var settings = {
                fields: [],
                header: [],
                title: '',
                message: '',
                filename: 'document',
                print: false,
                download: true,
                charset: ''
            };
            $.extend(true, settings, config);
            var _data = dt.rows().data();
            var thead = '<thead>';
            thead += '<tr>';
            for (var i in settings.header) {
                thead += '<th>' + settings.header[i] + '</th>';
            }
            thead += '</tr>';
            thead += '</thead>';
            var tbody = '<tbody>';
            for (var i = 0; i < _data.length; i++) {
                var row = _data[i];
                var tr = '<tr>';
                for (var fieldIndex in settings.fields) {
                    var field = settings.fields[fieldIndex];
                    tr += '<td>' + (row[field] == null ? '' : row[field]) + '</td>';
                }
                tr += "</tr>\n";
                tbody += tr;
            }
            tbody += '</tbody>';
            var css = 'body {\
  font: normal medium/1.2 sans-serif;\
}\
table {\
  border-collapse: collapse;\
  width: 100%;\
}\
th, td {\
  padding: 0.25rem;\
  text-align: left;\
  border: 1px solid #ccc;\
}\
th {\
    text-align: center;\
}\
tbody tr:nth-child(odd) {\
  background: #eee;\
}';
            var charset = '';
            if (settings.charset != '') {
                charset = settings.charset;
            } else {
                charset = document.characterSet || document.charset;
            }

            var title = settings.title;
            if (title == '') {
                title = $('title').text();
            }
            var table = '';
            table += '<style rel="stylesheet">'+ css +'</style>';
            table += '<table>' + thead + tbody + '</table>';
            var output = '<center><h1>' + title + '</h1></center>' + (settings.message != '' ? '<center><p>' + settings.message + '</p></center>' : '') + table;

            if (settings.download == true) {
                var blob = new Blob(["\ufeff", '<body>'+ output +'</body>'], {
                    type: 'application/html;charset='+ charset,
                    encoding: charset
                });
                saveAs(blob, settings.filename + '.html');
            } else {
                var win = window.open('', '');
                win.document.close();
                win.document.head.innerHTML = '<title>'+ title +'</title>';
                win.document.body.innerHTML = output;
                setTimeout(function() {
                    if (settings.print) {
                        win.print();
                        win.close();
                    }
                }, 250);
            }
        },
        print: function(dt, config) {
            this.html(dt, $.extend({}, config, {
                print: true,
                download: false
            }));
        },
        xml: function(dt, config) {
            var settings = {
                fields: [],
                header: [],
                separator: ',',
                title: '',
                message: '',
                filename: 'document',
                charset: ''
            };
            $.extend(true, settings, config);
            var _data = dt.rows().data();
            var output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
            output += "<Data>\n";
            for (var i = 0; i < _data.length; i++) {
                output += "\t<Column>\n";
                var row = _data[i];
                for (var fieldIndex in settings.fields) {
                    var field = settings.fields[fieldIndex];
                    output += "\t\t<" + field + ">" + (row[field] == null ? '' : row[field]) + "</" + field + ">\n";
                }
                output += "\t</Column>\n";
            }
            output += "</Data>";

            var charset = '';
            if (settings.charset != '') {
                charset = settings.charset;
            } else {
                charset = document.characterSet || document.charset;
            }

            saveAs(new Blob(["\ufeff", output], {
                type: 'application/xml;charset='+ charset,
                encoding: charset
            }), settings.filename + '.xml');
        },
    };
})(jQuery);