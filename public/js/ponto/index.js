const Ponto = function (){
    const generationTable = () => {
        let columns = [
            {name: 'id', data: 'id'},
            {name: 'empresa_cod', data: 'empresa_cod'},
        ];
        let columnDefs = [{
            targets: 0,
            title: 'ID',
            class: 'text-center',
            orderable: true
        },
            {
                targets: 1,
                class: 'text-center',
                title: 'empresa_cod',
            }];

        let functionDrawCallback = function () {}

        let functionFinishedCallback = function () {}

        const lengthChange = true;
        const lengthMenu = [10, 25, 50, 100];
        const pageLengthDefault = 10;

        Datatable.init($('.table_ponto'), route('loadGrid'), columns, columnDefs, functionDrawCallback, functionFinishedCallback, [[0, 'desc']], false, '', lengthChange, lengthMenu, pageLengthDefault)
    }

    return {
        init: function () {
            generationTable();
        }
    }
}();
