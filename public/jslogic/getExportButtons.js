function getExportButtons(tableId, exportColumns) {
    return [
        {
            extend: 'copyHtml5',
            text: '&nbsp;<i class="fa fa-files-o">&nbsp; Copy </i>',
            className: "btn-sm btn btn-danger",
            footer: true,
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
            footer: true,
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
            footer: true,
            title: 'AdminLT || Clients Data',
            exportOptions: {
                columns: exportColumns
            }
        },
        // {
        //     extend: 'pdfHtml5',
        //     text: '&nbsp;<i class="fa fa-file-pdf-o">&nbsp; PDF</i>',
        //     className: "btn-sm btn btn-danger",
        //     orientation: 'landscape',
        //     pageSize: 'A3',
        //     titleAttr: 'PDF',
        //     footer: true,
        //     title: 'AdminLT || Clients Data',
        //     customize: function (doc) {
        //         doc.pageMargins = [10, 10, 10, 10];
        //         doc.defaultStyle.fontSize = 7;
        //         doc.styles.tableHeader.fontSize = 7;
        //         doc.styles.tableFooter.fontSize = 15;
        //         doc.styles.title.fontSize = 15;

        //         doc['footer'] = function (page, pages) {
        //             return {
        //                 columns: [
        //                     {
        //                         alignment: 'center',
        //                         text: ['Clients Data from CodeTech Engineers'],
        //                     },
        //                     {
        //                         alignment: 'right',
        //                         text: ['page ', { text: page.toString() }, ' of ', { text: pages.toString() }],
        //                     }
        //                 ],
        //                 margin: [10, 0]
        //             };
        //         };

        //         var objLayout = {};
        //         objLayout['hLineWidth'] = function () { return .5; };
        //         objLayout['vLineWidth'] = function () { return .5; };
        //         objLayout['hLineColor'] = function () { return '#aaa'; };
        //         objLayout['vLineColor'] = function () { return '#aaa'; };
        //         objLayout['paddingLeft'] = function () { return 4; };
        //         objLayout['paddingRight'] = function () { return 4; };
        //         doc.content[1].layout = objLayout;
        //         doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
        //         doc.defaultStyle.alignment = 'center';
        //         doc.styles.tableHeader.alignment = 'center';
        //     },
        //     exportOptions: {
        //         columns: exportColumns
        //     }
        // },
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

        // Custom footer with page numbers
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

        // Table layout styling
        var objLayout = {};
        objLayout['hLineWidth'] = function () { return .5; };
        objLayout['vLineWidth'] = function () { return .5; };
        objLayout['hLineColor'] = function () { return '#aaa'; };
        objLayout['vLineColor'] = function () { return '#aaa'; };
        objLayout['paddingLeft'] = function () { return 4; };
        objLayout['paddingRight'] = function () { return 4; };
        doc.content[1].layout = objLayout;

        // Responsive column widths
        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
        doc.defaultStyle.alignment = 'center';
        doc.styles.tableHeader.alignment = 'center';

        // 🔽 Append tfoot manually at the end (one-time footer)
        var tfoot = document.querySelector("#example tfoot tr");
        if (tfoot) {
            var footerRow = [];
            tfoot.querySelectorAll("th, td").forEach(function (cell) {
                footerRow.push({
                    text: cell.textContent.trim(),
                    style: 'tableFooter',
                    alignment: 'center'
                });
            });
            // Add it after the last data row
            doc.content[1].table.body.push(footerRow);
        }
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
            footer: true,
            title: 'AdminLT || Clients Data',
               exportOptions: {
        columns: exportColumns,
        // 👇 Don't include tfoot automatically
        modifier: {
            page: 'all'
        },
        stripHtml: false
    },
    customize: function (win) {
        // Remove tfoot from auto-printing
        $(win.document.body).find('tfoot').remove();

        // Clone and append tfoot as last row in tbody
        var tfootRow = $('#example tfoot tr').clone();
        if (tfootRow.length) {
            var footerCells = '';
            tfootRow.find('th, td').each(function () {
                footerCells += '<td style="font-weight:bold; text-align:center;">' + $(this).text().trim() + '</td>';
            });

            $(win.document.body).find('table tbody').append('<tr>' + footerCells + '</tr>');
        }

        // Optional styling
        $(win.document.body).css('font-size', '10pt').find('table')
            .addClass('compact')
            .css('font-size', 'inherit');
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
            footer: true,
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
            footer: true,
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
