function getExportButtons(tableId, exportColumns) {
    return [
        {
            extend: 'copyHtml5',
            text: '&nbsp;<i class="fa fa-files-o">&nbsp; Copy </i>',
            className: "btn-sm btn btn-danger",
            titleAttr: 'Copy',
            exportOptions: {
                columns: exportColumns
            }
        },
        {
            text: '&nbsp;{ } &nbsp; JSON',
            className: "btn-sm btn btn-danger",
            titleAttr: 'JSON',
            exportOptions: {
                columns: exportColumns
            },
            action: function (e, dt, button, config) {
                var data = dt.buttons.exportData();
                $.fn.dataTable.fileSave(
                    new Blob([JSON.stringify(data)]),
                    'Export.json'
                );
            }
        },
        {
            extend: 'excelHtml5',
            text: '&nbsp;<i class="fa fa-file-excel-o">&nbsp; Excel</i>',
            className: "btn-sm btn btn-danger",
            titleAttr: 'Excel',
            title: 'AdminLT || Clients Data',
            exportOptions: {
                columns: exportColumns
            }
        },
        {
            extend: 'csvHtml5',
            text: '&nbsp;<i class="fa fa-file-text-o">&nbsp; CSV</i>',
            className: "btn-sm btn btn-danger",
            titleAttr: 'CSV',
            title: 'AdminLT || Clients Data',
            exportOptions: {
                columns: exportColumns
            }
        },
        {
            extend: 'pdfHtml5',
            text: '&nbsp;<i class="fa fa-file-pdf-o">&nbsp; PDF</i>',
            className: "btn-sm btn btn-danger",
            orientation: 'landscape',
            pageSize: 'A3',
            titleAttr: 'PDF',
            title: 'AdminLT || Clients Data',
            customize: function (doc) {
                doc.pageMargins = [10, 10, 10, 10];
                doc.defaultStyle.fontSize = 7;
                doc.styles.tableHeader.fontSize = 7;
                doc.styles.tableFooter.fontSize = 15;
                doc.styles.title.fontSize = 15;

                doc['footer'] = function (page, pages) {
                    return {
                        columns: [
                            {
                                alignment: 'center',
                                text: ['Clients Data from CodeTech Engineers'],
                            },
                            {
                                alignment: 'right',
                                text: ['page ', { text: page.toString() }, ' of ', { text: pages.toString() }],
                            }
                        ],
                        margin: [10, 0]
                    };
                };

                var objLayout = {};
                objLayout['hLineWidth'] = function () { return .5; };
                objLayout['vLineWidth'] = function () { return .5; };
                objLayout['hLineColor'] = function () { return '#aaa'; };
                objLayout['vLineColor'] = function () { return '#aaa'; };
                objLayout['paddingLeft'] = function () { return 4; };
                objLayout['paddingRight'] = function () { return 4; };
                doc.content[1].layout = objLayout;
                doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                doc.defaultStyle.alignment = 'center';
                doc.styles.tableHeader.alignment = 'center';
            },
            exportOptions: {
                columns: exportColumns
            }
        },
        {
            extend: 'print',
            text: '&nbsp;<i class="fa fa-print">&nbsp; Print</i>',
            className: "btn btn-sm btn-danger",
            titleAttr: 'Print',
            title: 'AdminLT || Clients Data',
            exportOptions: {
                columns: exportColumns
            }
        },
        {
            className: "btn btn-sm btn-danger",
            titleAttr: 'TXT',
            text: '<i class="fa fa-fw fa-file-text-o">&nbsp; TXT</i>',
            action: function (e, dt, node, config) {
                doExport(tableId, { type: 'txt' });
            }
        },
        {
            className: "btn btn-sm btn-danger",
            titleAttr: 'SQL',
            text: '<i class="fa fa-fw fa-database">&nbsp; SQL</i>',
            action: function (e, dt, node, config) {
                doExport(tableId, { type: 'sql' });
            },
            exportOptions: {
                modifier: {
                    page: 'all'
                },
                columns: exportColumns
            }
        },
        {
            className: "btn btn-sm btn-danger",
            titleAttr: 'Doc',
            text: '<i class="fa fa-fw fa-file-word-o">&nbsp; Docx</i>',
            action: function (e, dt, node, config) {
                doExport(tableId, { type: 'doc', mso: { pageOrientation: 'landscape' } });
            },
            exportOptions: {
                modifier: {
                    page: 'all'
                },
                columns: exportColumns
            }
        },
        {
            className: "btn btn-sm btn-danger",
            titleAttr: 'PNG',
            text: '<i class="fa fa-fw fa-image">&nbsp; PNG</i>',
            action: function (e, dt, node, config) {
                doExport(tableId, { type: 'png' });
            },
            exportOptions: {
                modifier: {
                    page: 'all'
                },
                columns: exportColumns
            }
        }
    ];
}
