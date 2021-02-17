import React from "react";

import Chart from "react-apexcharts";

class MoreHistory extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            series: [{
                name: 'Hours Boots Worn',
                data: this.props.data.hours,
            }],
            options: {
                title: {
                    text: this.props.data.start_date + ' to ' + this.props.data.end_date,
                    align: 'center',
                },
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
                    categories: this.props.data.days
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
    // note: this only shows two to one week ago currently
    render() {
        return (
            <div className={"mt-8"}>
                {this.props.data.hours !== undefined && <Chart
                    className={"inline-block md:w-1/3"}
                    options={this.state.options}
                    series={this.state.series}
                    type="bar"
                />}
                {this.props.data.hours === undefined && <p className={"text-red-500"}>No data available for previous weeks</p>}
            </div>
        );
    }
}

export default MoreHistory;
