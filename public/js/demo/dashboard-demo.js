$(function() {

    Morris.Area({
        element: 'morris-area-chart',
        data: [{
            period: '2010 Q1',
            balance: 26660,
            allotment: 24860,
            expense: 26470
        }, {
            period: '2010 Q2',
            balance: 27780,
            allotment: 22940,
            expense: 24410
        }, {
            period: '2010 Q3',
            balance: 49120,
            allotment: 19690,
            expense: 25010
        }, {
            period: '2010 Q4',
            balance: 37670,
            allotment: 35970,
            expense: 56890
        }, {
            period: '2011 Q1',
            balance: 68100,
            allotment: 19140,
            expense: 22930
        }, {
            period: '2011 Q2',
            balance: 56700,
            allotment: 42930,
            expense: 18810
        }, {
            period: '2011 Q3',
            balance: 48200,
            allotment: 37950,
            expense: 15880
        }, {
            period: '2011 Q4',
            balance: 50730,
            allotment: 59670,
            expense: 51750
        }, {
            period: '2012 Q1',
            balance: 106870,
            allotment: 44600,
            expense: 20208
        }, {
            period: '2012 Q2',
            balance: 84302,
            allotment: 57103,
            expense: 17910
        }],
        xkey: 'period',
        ykeys: ['balance', 'allotment', 'expense'],
        labels: ['balance', 'allotment', 'expense'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

	 Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Books",
            value: 125000
        }, {
            label: "Online Subscriptions",
            value: 30000
        }, {
            label: "Others",
            value: 2000
        }],
        resize: true
    });
    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });

});
