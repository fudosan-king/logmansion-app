import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import '../../../models/schedule.dart';
import '../../../widgets/colors.dart';
import 'schedule_item.dart';

class ScheduleWidget extends StatefulWidget {
  const ScheduleWidget({super.key});

  @override
  State<ScheduleWidget> createState() => _ScheduleWidgetState();
}

class _ScheduleWidgetState extends State<ScheduleWidget> {
  bool showAll = false;

  @override
  Widget build(BuildContext context) {
    List<Schedule> schedules = [
      Schedule(
          id: "1",
          name: 'Meeting1',
          description: '今回お借入致します金額がご融資可能かどうかを金融機関に審査致します。この住宅ローン の事前審査に必要な書類は、M',
          date: "25.4.2024",
          position: 1),
      Schedule(
          id: "2",
          name: 'Meeting2',
          description: '9:00 AM',
          date: "25.4.2024",
          position: 1),
      Schedule(
          id: "3",
          name: 'Meeting3',
          description: '9:00 AM',
          date: "25.4.2024",
          position: 1),
      Schedule(
          id: "4",
          name: 'Meeting4',
          description: '9:00 AM',
          date: "25.4.2024",
          position: 1),
      Schedule(
          id: "5",
          name: 'Meeting5',
          description: '9:00 AM',
          date: "25.4.2024",
          position: 1),
      Schedule(
          id: "6",
          name: 'Meeting6',
          description: '9:00 AM',
          date: "25.4.2024",
          position: 1),
    ];
    return Column(
      mainAxisSize: MainAxisSize.min,
      mainAxisAlignment: MainAxisAlignment.start,
      crossAxisAlignment: CrossAxisAlignment.center,
      children: [
        Container(
          width: 335.w,
          clipBehavior: Clip.antiAlias,
          decoration: const BoxDecoration(),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            mainAxisAlignment: MainAxisAlignment.start,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              ListView.builder(
                key: ValueKey<int>(showAll ? schedules.length : 2),
                padding: const EdgeInsets.only(top: 0, bottom: 0),
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                itemCount: showAll ? schedules.length : 2,
                itemBuilder: (BuildContext context, int index) {
                  return ScheduleItem(schedule: schedules[index]);
                },
              ),
              Center(
                child: AnimatedSwitcher(
                  duration: const Duration(milliseconds: 100),
                  child: IconButton(
                    icon: Icon(
                      showAll
                          ? Icons.keyboard_arrow_up_outlined
                          : Icons.keyboard_arrow_down_outlined,
                      color: AppColors.buttonColor,
                    ),
                    onPressed: () {
                      setState(() {
                        showAll = !showAll;
                      });
                    },
                  ),
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }
}