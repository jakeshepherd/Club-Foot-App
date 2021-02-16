import React from "react";

import Chart from "react-apexcharts";

class MoreHistory extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            series: [{
                name: '',
                data: []
            }],
            options: {
                chart: {
                    type: 'bar',
                    weight: "100%",
                    height: "100%",
                    background: '#fff'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    title: {
                        text: 'Days'
                    },
                    categories: [],
                },
                yaxis: {
                    title: {
                        text: 'Hours'
                    }
                },
                fill: {
                    opacity: 1,
                    colors: [function ({value}) {
                        if (value < 12) {
                            return '#FF0000'
                        } else if (value >= 12 && value < 14) {
                            return '#FFA500'
                        } else {
                            return '#008000'
                        }
                    }]
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " hours"
                        }
                    }
                }
            },
            responsive: [
                {
                    breakpoint: 1000,
                    options: {
                        legend: {
                            position: "bottom"
                        }
                    }
                }
            ]
        };
    }
    render() {
        return (
            <div>
                <Chart
                    className={"inline-block md:w-1/3"}
                    options={this.state.options}
                    series={this.state.series}
                    type="bar"
                />
            </div>
        );
    }
}

export default MoreHistory;
