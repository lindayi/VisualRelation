#!/usr/bin/env python
# coding=utf-8

from xml.etree import ElementTree
from dircache import listdir
import sys
import datetime

start = datetime.datetime.now()

reload(sys)
sys.setdefaultencoding("utf-8")

org_path = './upload/OrgProfile/'
person_path = './upload/PersonProfile/'
location_path = './upload/LocationProfile/'

org_list = listdir(org_path)
person_list = listdir(person_path)
location_list = listdir(location_path)

xml_list = []
for org in org_list:
    org = org_path + org 
    xml_list.append(org)

for person in person_list:
    person = person_path + person
    xml_list.append(person)

for location in location_list:
    location = location_path + location
    xml_list.append(location)

doc_sql = open('./upload/doc.sql', 'a+')
relation_sql = open('./upload/relation.sql', 'a+')
profile_sql = open('./upload/profile.sql', 'a+')

print >> doc_sql, "INSERT INTO doc VALUES"
print >> profile_sql, "INSERT INTO profile VALUES"
print >> relation_sql, "INSERT INTO relation VALUES"

doc_sql.close()
relation_sql.close()
profile_sql.close()

total = len(xml_list)
count = 0
error_xml = 0
for xml in xml_list:
    try:
        with open(xml, 'rt') as f:
            tree = ElementTree.parse(f)
        # first_flag 用来记录第一次的source
        first_read_flag = 1
        second_read_flag = 0
        sql = open('./upload/v3.sql', 'a+')
        doc_sql = open('./upload/doc.sql', 'a+')
        relation_sql = open('./upload/relation.sql', 'a+')
        profile_sql = open('./upload/profile.sql', 'a+')
        for node in tree.iter():
            # 检索 profileid, profiletype, profilesubtype
            if (node.tag == 'profile'):
                p_profilesubtype = ''
                for name, value in node.attrib.items():
                    if (name == 'id'):
                        p_profileid = value
                        r_sourceid = value
                    elif (name == 'type'):
                        if (value == 'LocationProfile'):
                            p_profiletype = 1
                        elif (value == 'OrgProfile'):
                            p_profiletype = 2
                        elif (value == 'PersonProfile'):
                            p_profiletype = 3
                        else:
                            p_profiletype = 0
                    elif (name == 'subtype'):
                        p_profilesubtype = value
            # 检索 profilename
            elif (node.tag == 'name'):
                p_profilename = node.text
            # 检索 sourcedoc sourceid pubtime realtime
            elif (node.tag == 'source' and first_read_flag):
                first_read_flag = 0
                # 对doc表来说，每个source节点都能生成一条SQL
                d_text = node.text
                for name, value in node.attrib.items():
                    if (name == 'doc'):
                        p_sourcedoc = value
                        d_file = value
                    elif (name == 'id'):
                        p_sourceid = value
                        d_sentenceid = value
                    elif (name == 'pubtime'):
                        p_pubtime = value
                    elif (name == 'realtime'):
                        p_realtime = value
                print >> doc_sql, "('%s', '%s', '%s'), " % (d_file, d_sentenceid, d_text)
            # 检索 mergeCount
            elif (node.tag == 'mergeCount'):
                p_mergecount = node.text
            # 检索 mentions
            elif (node.tag == 'mentions'):
                p_mentions = node.text
            # 检索 vip
            elif (node.tag == 'vip'):
                if (node.text == 'true'):
                    p_vip = 1
                elif (node.text == 'false'):
                    p_vip = 0
                else:
                    p_vip = node.text
            # 检索 type
            elif (node.tag == 'relation'):
                r_type = node.attrib.get('type')
            # 检索 destid 和 ne
            elif (node.tag == 'ne'):
                r_ne = node.text
                destid = node.attrib.get('id')
                if (destid):
                    r_destid = destid
                else:
                    r_destid = 0
            # 检索 doc, sentenceid, pubtime, realtime
            elif (node.tag == 'source' and second_read_flag):
                r_doc = d_file = node.attrib.get('doc')
                d_text = node.text
                d_sentenceid = r_sentenceid = node.attrib.get('id')
                r_pubtime = node.attrib.get('pubtime')
                r_realtime = node.attrib.get('realtime')
                if (d_text):
                    print >> doc_sql, "('%s', '%s', '%s')," % (d_file, d_sentenceid, d_text)
                # 对realation表来说每个relation都是一条SQL
                print >> relation_sql, "('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')," % (r_sourceid, r_destid, r_type, r_ne, r_doc, r_sentenceid, r_pubtime, r_realtime)
            second_read_flag = 1
        # 对profile表来说一个profile对应一条SQL语句
        print >> profile_sql, "('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')," % (p_profileid, p_profiletype, p_profilesubtype, p_profilename, p_sourcedoc, p_sourceid, p_pubtime, p_realtime, p_mergecount, p_mentions, p_vip)
        f.close()
        doc_sql.close()
        profile_sql.close()
        relation_sql.close()
        count = count + 1
        print "completed ",
        print format(count/(total+0.0), '.4%')
    except Exception:
        err = open('err_xml.txt', 'a+')
        print >> err, xml
        error_xml = error_xml + 1
        err.close()
        count = count + 1
        print "completed ",
        print format(count/(total+0.0), '.4%')
print "error xml: ",
print "%d" % error_xml

end = datetime.datetime.now()

print '%ds' % (end - start).seconds
