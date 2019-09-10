Yii2 C3JS Chart Widget
======================

Easily add [C3JS](http://c3js.org/) graphs to your Yii2 application.

![Screen Shot](https://www.programmerthailand.com/uploads/1/1463986621_yii2-c3js-chart-widget.jpg)

Install
-----
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require kongoon/yii2-c3js-chart
```

Usage
-----
To use this widget, insert the following code into a view file:
```php
use kongoon\c3js\C3JS;

echo C3JS::widget([
    'options' => [
        'data' => [
            'x' => 'x',
            'columns' => [
                ['x', '2016-01-01', '2016-02-01', '2016-03-01', '2016-04-01', '2016-05-01', '2016-06-01'],
                ['data1', 30, 200, 100, 400, 150, 250],
                ['data2', 50, 20, 10, 40, 15, 25]
            ],
            'types' => [
                'data1' => 'bar',
                'data2' => 'bar'
            ],
        ],

        'axis' => [
            'y' => [
                'label' => [
                    'text' => 'Y Label',
                    'position' => 'outer-middle',
                ]
            ],
            'x' => [
                'type' => 'timeseries',
                'tick' => [
                    'format' => '%Y-%m-%d'
                ],
                'label' => [
                    'text' => 'X Label',
                    'position' => 'outer-middle',
                ]
            ]
        ]
    ],

]);
```
