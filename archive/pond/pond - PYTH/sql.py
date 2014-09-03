import time
import datetime
import os
import sqlite3

# unused sensors
temp1 = 0.0
temp2 = 0.0
humidity = 0
baro = 0.0

# used sensors
temp_pond_top = 0.0
temp_pond_bot = 0.0
temp_pond_out = 0.0
temp_shed_top = 0.0
temp_shed_bot = 0.0

seen = []
StartTime = int(time.time())
now = datetime.datetime.now()
sec = int(now.second)
done = 0
# print("Sec: " + str(sec))
while 1:
    now = datetime.datetime.now()
    sec = int(now.second)
    if sec >= 1:
        done = 0
        # print("Sec: " + str(sec))
    # only execute the following on the second once
    if (sec == 0) and (done == 0):
        # print ("Inside...")
        StartTime = int(time.time())
        for f in os.listdir('/mnt/1wire'):
            try:
                # see if we can read a type
                myfile = open('/mnt/1wire/uncached/' + f + '/type')
                type = myfile.readline()
                myfile.close
                # if so and it's a DS18B20
                #   then see if it will give us a value
                if type == 'DS18B20':
                    myfile = open('/mnt/1wire/' + f + '/temperature')
                    temp = float(myfile.readline())
                    myfile.close
                    # it's a DS18B20 that's working
                    # (otherwise we'd be at the 'except' now
                if f == '28.E4EE50050000':
                    temp_pond_top = temp
                elif f == '28.334950050000':
                    temp_pond_bot = temp
                elif f == '28.55C150050000':
                    temp_pond_out = temp
                elif f == '28.8FEB50050000':
                    temp_shed_top = temp
                elif f == '28.A84A51050000':
                    temp_shed_bot = temp
                else:
                    pass
            except IOError:
                pass
        # print("DB Insert")
        DateVal = str(now.strftime("%Y-%m-%d %H:%M:%S"))
        # print("Temps at:    " + DateVal)
        # print("Pond Top:    " + str(temp_pond_top))
        # print("Pond Bottom: " + str(temp_pond_bot))
        # print("Pond Out:    " + str(temp_pond_out))
        # print("Shed Top:    " + str(temp_shed_top))
        # print("Shed Bottom: " + str(temp_shed_bot))
        # EndTime = int(time.time())
        # print("Stop: " + str(EndTime))

        db = sqlite3.connect('/home/philipw/pond/pond.db')
        cursor = db.cursor()
        cursor.execute('''INSERT INTO temps(timestamp, dt, pond_top, \
                pond_bot, pond_out, shed_top, shed_bot, temp1, temp2, \
                humidity, baro) VALUES(?,?,?,?,?,?,?,?,?,?,?)''', \
                (StartTime, DateVal, temp_pond_top, temp_pond_bot, \
                temp_pond_out, temp_shed_top, temp_shed_bot, temp1, \
                temp2, humidity, baro))
        db.commit()
        done = 1
        # print(" ")
    time.sleep(0.5)
# we should not get here)

