 # Summer Internship 3rd Project

 <h2> Relocating File App using Redis+MySql+Flask+asyncio
 (Redis+MySql+Flask 를 이용한 비동기 파일 재배치 프로그램)

 <div style="text-align: right"> 작성자 : 김지희


 ### 목차

 #### 1. 프로젝트 개요

#### 2. API 기능 설명 및 구현 상세 정보

#### 3. 구현 결과

#### 4. 프로젝트 후기

-----------

 <h3> 1. 프로젝트 개요
 - 목적
  <Br> 컨텐츠에 대한 접근 수가 증가하면 해당 컨텐츠가 위치한 서버에 대한 트래픽 양 또한 증가하여 용량이 더 큰 서버로의 컨텐츠 재배치가 요구된다.
 이를 실시간으로 수행하기 위하여 메모리 기반의 realtime database 인 redis 와 파이썬의 asyncio 를 이용한 비동기 파일 재배치 프로그램을 제작한다.

- 개발 환경 및 requirements
   - OS : ubutu 16.04
   - python==3.6.5 , MySQL==5.7 , Flask==1.0.2 , PyMySQL==0.9.2 , redis-server==4.0.10

-  Data Flow Diagram

![Dataflow](https://i.imgur.com/vIeEdW1.png)

- Flow chart

 ![flow chart]( https://i.imgur.com/BaY1fk4.png width=100 height="50")

###  2. API 구현 정보

##### 컨텐츠 정보 쿼리 및 redis 업데이트
1. 사용자가 컨텐츠를 조회하면 컨텐츠의 cid 와 count 정보를 포함하여 API를 호출한다. (e.g.curl http://192.168.10.108:5001/post_sentence -d "cid=3&count=664"
)
- db_query 모듈을 이용하여 database의 contents table 과 level table에서 post 된 cid를 가진 content의 현재위치와 목적위치를 반환한다. <br>
![contents](https://i.imgur.com/L8I5vfa.png "contents")              ![level](https://i.imgur.com/OArMB1b.png "level")
- cid를 Key 값으로 현재 위치와 counts에 따른 목적 위치가 다른 경우 status 에 'update' 라는 문자열을, 현재위치와 목적 위치가 같은 경우 status에 'done' 이라는 문자열을 삽입하여 redis database에 json 형식으로 set(worker_id 는 이 후 단계에서 할당되기 때문에 초기값은 null값으로 한다.)
<br>(e.g.)
{'3':{"cid": "3", "count": "664", "target": "bronze", "db_level": "silver", "filename": "c.mp4", "worker_id": null, "status": "update"}} 형식으로 저장된다.

##### redis 값 체크 및 MySql database 업데이트
1. worker가 파일을 재배치한 후 해당 contents 의 status 를 'done' 으로 바꾸고 API 를 호출한다. (e.g. curl http://192.168.10.108:5000/update_sentence -d "cid=3"
)
2. request를 받으면 cid 를 Key 값으로 redis에서 해당 content의 status 가 'done' 인지 검사하고 MySQL의 contents table 에 새로운 level 과 update time 을 업데이트한다.
만약 status 가 'done' 이 아니면 "check your status again" 메세지를 반환한다.


### 3. 구현 결과
##### 컨텐츠 정보 쿼리 및 redis 업데이트
    foo@bar:~/$ curl http://192.168.10.108:5000/post_sentence -d "cid=7&count=1964"
    {"cid": "7", "count": "1964", "target": "silver", "db_level": "bronze", "filename": "g.mp4", "worker_id": null, "status": "update"}

##### redis 값 체크 및 MySql database 업데이트
    # db update 후 해당 content 의 cid 반환
    foo@bar:~/$ curl http://192.168.10.108:5000/update_sentence -d "cid=7"
    7
    foo@bar:~/$ curl http://192.168.10.108:5000/update_sentence -d "cid=8"
    check your status again
![content_7](https://i.imgur.com/sMEIYlz.png)

### 4. 프로젝트 후기
##### 개선할점
- scalability 를 고려하여 하드코딩, 반복되는 코드를 최소화 해야한다.
- 더 많은 에러 발생 경우에 대한 처리 방법이 추가되어야 한다.

##### 느낀점
-
