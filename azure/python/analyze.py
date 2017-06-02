
# coding: utf-8

<<<<<<< HEAD
# In[2]:
=======
# In[3]:
>>>>>>> 48c3d1d188b4f275f6d8911eb5766d371854a9ff

#!/usr/bin/python

import argparse
import pymysql
import plotly
<<<<<<< HEAD
import itertools
=======
# plotly.offline.init_notebook_mode()
>>>>>>> 48c3d1d188b4f275f6d8911eb5766d371854a9ff
from plotly.graph_objs import *
from plotly.offline.offline import _plot_html
from datetime import date, datetime, timedelta

<<<<<<< HEAD
<<<<<<< HEAD
parser = argparse.ArgumentParser(description='Analyze ')
parser.add_argument("--compare", help="Compare attributes, including assigned, not_assigned, guest. ex.: --compare assigned,not_assigned")
parser.add_argument("--fromDate", help="From date for target's period or between's period. ex.: --from 2015-04-01")
parser.add_argument("--toDate", help="Last date for target's period. ex.: --to 2015-04-01")
parser.add_argument("--step", help="Select one time step format for between's period, including week, month, season. ex.: --step season")

parser.add_argument("--between", help="Select one between attributes, including masseur, helper, shop. ex.: --between masseur", default="masseur")

parser.add_argument("--masseur", help="Target masseur Name", default="")
parser.add_argument("--helper", help="Target helper Name", default="")
parser.add_argument("--shop", help="Target shop Name", default="")

parser.add_argument("--by", help="Select one aggregate argument, including sum, count, average. ex.: --by sum", default="sum")

parser.add_argument("--barMode", help="Select one bar char mode , including stack,group. ex.: --by sum", default="group")

args = parser.parse_args()
if args.compare != None:
    compares = args.compare.split(',')
target_period = None
between = args.between
if args.fromDate != None and args.toDate != None:
    target_period = {"from":datetime.strptime(args.fromDate,"%Y-%m-%d"), "to":datetime.strptime(args.toDate,"%Y-%m-%d")}
elif args.fromDate != None and args.step != None:
    between = {"from":args.fromDate, "step":args.step}

=======
>>>>>>> 48c3d1d188b4f275f6d8911eb5766d371854a9ff
def query(compares, targets, between, by, barMode):
=======
def query(compares, targets, between, by, chartMode, barMode):
>>>>>>> 359edd2bcf5c0c311730628254fc716b47225830
    # compares = ['assigned', 'not_assigned', 'guest']
    # target = {"m":"","h":"","s": "","p":""}
    # between = 'masseur'|'helper'|'shop'|'date'
    conn = pymysql.connect(host='ap-cdbr-azure-east-c.cloudapp.net', port=3306, user='b4aa79b2c77ddc', passwd='23d314ad', db='D4SG_VIM',charset='utf8')
    cur = conn.cursor()
    cur.execute("SELECT * FROM worklog")  
    worklogs = list(cur.fetchall())
    cur.execute("SELECT * FROM masseur")
    masseurs = list(cur.fetchall())
    cur.execute("SELECT * FROM helper")
    helpers = list(cur.fetchall())
    cur.execute("SELECT * FROM shop")
    shops = list(cur.fetchall())
    
    # find target 
    target_masseurs = masseurs
    target_helpers = helpers
    target_shops = shops
    target_worklogs = None
    timeSeriesPlot = False
    if targets["m"] != "":
        target_masseurs = filter(lambda x: x[1] == targets["m"].decode("utf-8"), target_masseurs)
        for i in target_masseurs:
            worklogs = filter(lambda x: x[1] == i[0], worklogs)
    if targets["h"] != "":
        target_helpers = filter(lambda x: x[1] == targets["h"].decode("utf-8"), target_helpers)
        for i in target_helpers:
            worklogs = filter(lambda x: x[2] == i[0], worklogs)
    if targets["s"] != "":
        target_shops = filter(lambda x: x[1] == targets["s"].decode("utf-8"), target_shops)
        for i in target_shops:
            worklogs = filter(lambda x: x[3] == i[0], worklogs)
    fromDate = None
    toDate = None
<<<<<<< HEAD
    if targets["p"] != None:
=======
    if targets["p"] != None :
>>>>>>> 48c3d1d188b4f275f6d8911eb5766d371854a9ff
        timeSeriesPlot = True
        fromDate = targets["p"]["from"].date()
        toDate = targets["p"]["to"].date()
        worklogs = filter(lambda x: x[7] >= fromDate and x[7] <= toDate, worklogs)
        
<<<<<<< HEAD
    dic = {}
    # between condition
#     dic = {
#         TARGET_NAME:[ WORKLOGS ]
#     }
    if between == "masseur":
        for masseur in target_masseurs:
            mid = masseur[0]
            dic[masseur[1]] = filter(lambda x: x[1] == mid ,worklogs)
    elif between == "helper":
        for helper in target_helpers:
            hid = helper[0]
            dic[helper[1]] = filter(lambda x: x[2] == hid ,worklogs)
    elif between == "shop":
        for shop in target_shops:
            sid = shop[0]
            dic[shop[1]] = filter(lambda x: x[3] == sid ,worklogs)
#     elif between == "date":
#         ;
#         something to do
=======
# between condition
#     dataList = [
#         (TARGET_NAME,[ WORKLOGS ])
#     ]
    dataList = []
    if between == "masseur":
        for masseur in target_masseurs:
            mid = masseur[0]
            dataList.append((masseur[1],filter(lambda x: x[1] == mid ,worklogs)))
    elif between == "helper":
        for helper in target_helpers:
            hid = helper[0]
            dataList.append((helper[1],filter(lambda x: x[2] == mid ,worklogs)))
    elif between == "shop":
        for shop in target_shops:
            sid = shop[0]
            dataList.append((shop[1],filter(lambda x: x[3] == sid ,worklogs)))
    else:
#     for time period
#     dataList = [
#         (TIME_PERIOD,[ WORKLOGS ])
#     ]
        fromDate = between["from"].date()
        toDate = between["to"].date()
        if between["step"] == "week":
            step = timedelta(days=7)
            to = fromDate + step
            while to <= toDate:
                dateRange = fromDate.strftime("%Y-%m-%d")+'至'+(to-timedelta(days=1)).strftime("%Y-%m-%d")
                dataList.append((dateRange,filter(lambda x: x[7] >= fromDate and x[7] < to, worklogs)))
                fromDate = to
                to = to + step
        elif between["step"] == "month":
            while fromDate.month <= toDate.month:
                month = fromDate.strftime("%Y年%m月")
                dataList.append((month,filter(lambda x: x[7].month == fromDate.month,worklogs)))
                fromDate = add_months(fromDate,1)
        elif between["step"] == "season":
            while fromDate.month <= toDate.month:
                to = add_months(fromDate,2)
                monthRange = fromDate.strftime("%Y年%m月") +'至'+to.strftime("%Y年%m月")
                dataList.append((monthRange,filter(lambda x: x[7].month >= fromDate.month and x[7].month < to.month, worklogs)))
                fromDate = add_months(fromDate,3)
>>>>>>> 48c3d1d188b4f275f6d8911eb5766d371854a9ff
    # compare result and create plot
    
    # compare result and create plot 
    data = []
    layout = None
    table = {"assigned":4, "not_assigned": 5, "guest": 6}
    chineseName = {"assigned":"指定", "not_assigned": "未指定", "guest": "來客數"}
    if timeSeriesPlot:
<<<<<<< HEAD
<<<<<<< HEAD
        daynum = fromDate - toDate
        x = [toDate + timedelta(days=num) for num in range(daynum.days, 1)]
        for name in dic.keys():
            y = [(date,reduce(lambda x, y: x + y[table["assigned"]], grp, 0)) for date, grp in itertools.groupby(dic[name], key=lambda x: x[7])]
=======
        # line char
=======
        # line chart
>>>>>>> 359edd2bcf5c0c311730628254fc716b47225830
        daynum = fromDate - toDate
        x = [toDate + timedelta(days=num) for num in range(daynum.days, 1)]
        for name, logs in dataList:
            if by == "sum":
                y = [(date,reduce(lambda x, y: x + y[table["assigned"]], grp, 0)) for date, grp in itertools.groupby(logs, key=lambda x: x[7])]
            elif by == "count":
                y = [(date,len(list(grp))) for date, grp in itertools.groupby(logs, key=lambda x: x[7])]
            elif by == "average":
                y = [(date, list(grp))for date, grp in itertools.groupby(logs, key=lambda x: x[7])]
                y = [(date,reduce(lambda x, y: x + y[table["assigned"]], grp, 0)/float(len(grp))) if len(grp) != 0 else (date, 0) for date, grp in y]
                
>>>>>>> 48c3d1d188b4f275f6d8911eb5766d371854a9ff
            for d in x: 
                if not d in [d for d,v in y]:
                    y.append((d, 0))
            y.sort(key=lambda a: a[0], reverse=False)
            trace = Scatter(
                    x = x,
                    y = [v for d,v in y],
                    name = name
            )
            data.append(trace)
        layout = dict(
<<<<<<< HEAD
 	         yaxis=dict(
                    title=','.join(compares),
                    titlefont=dict(
                        family='Arial, sans-serif',
                        size=14,
                        color='black'
                    )
                )
        
=======
            yaxis=dict(
                title=','.join(compares),
                titlefont=dict(
                    family='Arial, sans-serif',
                    size=14,
                    color='black'
                ),
            )
>>>>>>> 48c3d1d188b4f275f6d8911eb5766d371854a9ff
        )
        fig = Figure(data=data, layout=layout)
#         plot_html, plotdivid, width, height = _plot_html(fig, False, "", True, '100%', 525, False)
        plotly.offline.plot(fig)
    else:
<<<<<<< HEAD
<<<<<<< HEAD
        x = [mname for mname in dic.keys()]
        y = {}
        for compare in compares:
            values = []
            for name in x:
                values.append(reduce(lambda a, b: a + b[table[compare]], dic[name], 0))
            y[compare] = values
=======
        # bar char
=======
        # bar chart
>>>>>>> 359edd2bcf5c0c311730628254fc716b47225830
        x = map(lambda x: x[0], dataList)
        y = {}
        for compare in compares:
            values = []
            for name, logs in dataList:
                if by == "sum":
                    values.append(reduce(lambda a, b: a + b[table[compare]],logs , 0))
                elif by == "count":
                    values.append(len(logs))
                elif by == "average":
                    if len(logs) != 0:
                        values.append(reduce(lambda a, b: a + b[table[compare]],logs , 0)/float(len(logs)))
                    else:
                        values.append(0)
<<<<<<< HEAD
            y[compare] = values                
>>>>>>> 48c3d1d188b4f275f6d8911eb5766d371854a9ff
=======
            y[compare] = values 
        iterator = 0
>>>>>>> 359edd2bcf5c0c311730628254fc716b47225830
        for compare in compares:
            iterator +=1 
            if chartMode == "pie":
                xLeft = float(1)/len(compares) * (iterator-1)
                xRight = float(1)/len(compares) * iterator
                data.append({
                    "labels":x,
                    "values":y[compare],
                    "type":"pie",
                    "name":compare,
                    "domain": {'x': [xLeft, xRight],
                       'y': [0,1]}
                })
                layout = {}
            elif chartMode == "bar":
                trace = Bar(
                    x = x,
                    y = y[compare],
                    name = compare
                )
                data.append(trace)
                layout = Layout(
                    barmode= barMode
                )
        fig = Figure(data=data, layout=layout)
        plot_html, plotdivid, width, height = _plot_html(fig, False, "", True, '100%', 525, False)
#         plotly.offline.plot(fig)
        print plot_html
    cur.close()
    conn.close()
    
<<<<<<< HEAD
=======

parser = argparse.ArgumentParser(description='Analyze ')
parser.add_argument("--compare", help="Compare attributes, including assigned, not_assigned, guest. ex.: --compare assigned,not_assigned")
parser.add_argument("--fromDate", help="From date for target's period or between's period. ex.: --from 2015-04-01")
parser.add_argument("--toDate", help="Last date for target's period. ex.: --to 2015-04-01")
parser.add_argument("--step", help="Select one time step format for between's period, including week, month, season. ex.: --step season", default="")

parser.add_argument("--between", help="Select one between attributes, including masseur, helper, shop, period. ex.: --between masseur", default="masseur")

parser.add_argument("--masseur", help="Target masseur Name", default="")
parser.add_argument("--helper", help="Target helper Name", default="")
parser.add_argument("--shop", help="Target shop Name", default="")

parser.add_argument("--by", help="Select one aggregate argument, including sum, count, average. ex.: --by sum", default="sum")
parser.add_argument("--chartMode", help="Select one chart mode , including bar,pie. ex.: --chartMode pie", default="bar")
parser.add_argument("--barMode", help="Select one bar chart mode , including stack,group. ex.: --by sum", default="group")

args = parser.parse_args()
if args.compare != None:
    compares = args.compare.split(',')
target_period = None
between = args.between
step = args.step

if step != "":
    between = {"from":datetime.strptime(args.fromDate,"%Y-%m-%d"), "to":datetime.strptime(args.toDate,"%Y-%m-%d"), "step":step}
elif args.fromDate != None and args.toDate != None:
    target_period = {"from":datetime.strptime(args.fromDate,"%Y-%m-%d"), "to":datetime.strptime(args.toDate,"%Y-%m-%d")}

<<<<<<< HEAD
>>>>>>> 48c3d1d188b4f275f6d8911eb5766d371854a9ff
query(compares, {"m":args.masseur,"h":args.helper,"s":args.shop,"p":target_period}, between, args.by, args.barMode)
=======
query(compares, {"m":args.masseur,"h":args.helper,"s":args.shop,"p":target_period}, between, args.by, args.chartMode, args.barMode)
>>>>>>> 359edd2bcf5c0c311730628254fc716b47225830


# In[ ]:



