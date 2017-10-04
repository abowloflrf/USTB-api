# USTB-api

## elearning.ustb.edu.cn教务管理系统

### 验证密码
- `/getInfo` 

- 查询参数`?id=学号&pw=密码` 

- 密码正确返回:
```json
{
    "status": "OK",
    "jsessionid": "E716429461361F0A3BB44C9E8208187B"
}
```
- 密码错误或其他错误返回
```json
{
    "status": "ERROR",
    "jsessionid": "624ECC7D5CFDCACE40FDD2522A451C88"
}
```

### 查询所有成绩
- `/getScore`

- 查询参数`?id=学号&pw=密码`

- 返回
```json
{
    "status": "OK",
    "gpa": 4.00,
    "avg": 99.0,
    "scores": [
        {
            "semester": "2015-2016-1 ",
            "course_id": "2040185",
            "course_name": "工程制图基础",
            "course_type": "学科基础必",
            "course_period": "32",
            "course_credit": "2",
            "first_score": 85,
            "final_score": 85
        },
        {
            "semester": "2015-2016-1 ",
            "course_id": "4248001",
            "course_name": "计算机科学前沿技术选讲",
            "course_type": "本专业选",
            "course_period": "32",
            "course_credit": "2",
            "first_score": 89,
            "final_score": 89
        }
        ...
    ]
},
```

### 获取指定学期课表
- `/getTimetable`

- 查询参数`?id=学号&pw=密码&semester=2017-2018-1`

- 返回
```json
{
    "status": "OK",
    "timetable": [
        {
            "course_name": "毛泽东思想和中国特色社会主义理论体系概论II",
            "teachers": [
                "安静"
            ],
            "direct_msg": "(周4,第3节,1-16周 逸夫楼806) ",
            "capacity": 178,
            "credit": "2",
            "detail": {
                "21": [
                    "逸夫楼806",
                    "1-16周"
                ],
                "63": [
                    "逸夫楼806",
                    "1-16周"
                ],
                ... 
            }
        },
        ...
    ]
}
```
> detail中为每节课的上课地点,开头数字为上课具体时间,一天六节课一周七天一周就有42节课的时间,如63=42x**1**+6x**3**+**3** 代表这节课是第二教学周周四的第三节课

### 查询创新学分
`/getInnovativeCredit`

- 查询参数`?id=学号&pw=密码`

- 返回
```json
{
    "status": "OK",
    "total_credit": 1.0,
    "single_credit": [
        {
            "class_name": "APP开发与行业趋势",
            "credit": 0.2
        },
            {
            "class_name": "互联网前沿技术讲座",
            "credit": 0.2
        },
        ...
    ]
}
```

### 已获得选修课学分与成绩
- `/getElectiveScore`

- 查询参数`?id=学号&pw=密码`

- 返回
```json
{
    "status": "OK",
    "total_credit": 14,
    "need_credit": 15,
    "learned_courses": [
        {
            "course_name": "宝石鉴赏",
            "credit": 1,
            "score": 86
        },
        {
            "course_name": "“成功之道”——前途及领袖发展课程",
            "credit": 2,
            "score": 96
        },
        ...
    ]
}
```

###  查看某学期课程修改历史记录
-  `/getLogs`

- 查询参数`?id=学号&pw=密码&semester=2017-2018-2`

- 返回
```json
{
    "status": "OK",
    "selected_courses": [
        {
            "course_name": "毛泽东思想和中国特色社会主义理论体系概论II",
            "detail": "(周4,第3节,1-16周 逸夫楼806) "
        },
        {
            "course_name": "算法设计与分析",
            "detail": "(周3,第5节,1,3-6周 逸夫楼507) (周1,第5节,1-6周 逸夫楼507) "
        },
        ...
    ]
}
```

### 查看所有公选课列表
- `/getElectiveList`

- 查询参数`?id=学号&pw=密码`

- 返回
```json
{
    "status": "OK",
    "course_count": 153,
    "course_list": [
        {
            "course_name": "Office高级应用",
            "teachers": [
                "于泓"
            ],
            "direct_msg": "(周3,第6节,1-16周 信息楼B404(T)) ",
            "capacity": "59",
            "credit": "2",
            "detail": {
                "18": [
                    "信息楼B404(T)",
                    "1-16周"
                ],
                "60": [
                    "信息楼B404(T)",
                    "1-16周"
                ],
                ...
            }
        },
        ...
    ]
```

### 查看某学期要上的课程
- `/getSelectedCourses`

- 查询参数`?id=学号&pw=密码&semester=2017-2018-2`

- 返回
```json
{
    "status": "OK",
    "selected_courses": [
        {
            "course_name": "毛泽东思想和中国特色社会主义理论体系概论II",
            "detail": "(周4,第3节,1-16周 逸夫楼806) "
        },
        {
            "course_name": "算法设计与分析",
            "detail": "(周3,第5节,1,3-6周 逸夫楼507) (周1,第5节,1-6周 逸夫楼507) "
        },
        {
            "course_name": "操作系统",
            "detail": "(周4,第1节,2-12周 逸夫楼407) (周2,第1节,1-12周 逸夫楼805) (周4,第1节,1周 逸夫楼806) "
        },
        {
            "course_name": "数字电子技术实验(实验)",
            "detail": ""
        },
        ...
    ]
}
```