import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import '../../../models/schedule.dart';
import '../../../widgets/colors.dart';

class ScheduleItem extends StatelessWidget {
  const ScheduleItem({
    super.key,
    required this.schedule,
  });

  final Schedule schedule;

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: (){showCustomDialog(context, schedule);},
      child: Container(
        height: 47.h,
        padding: EdgeInsets.all(12.w),
        margin: EdgeInsets.only(bottom: 6.h),
        clipBehavior: Clip.antiAlias,
        decoration: ShapeDecoration(
          color: Colors.white,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
        ),
        child: SizedBox(
          height: 17.h,
          child: Row(
            mainAxisSize: MainAxisSize.min,
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              Container(
                width: 16.w,
                height: 16.w,
                clipBehavior: Clip.antiAlias,
                decoration: const BoxDecoration(),
                child:
                Image.asset("assets/images/icon_atention.png", width: 16.w),
              ),
              SizedBox(width: 6.w),
              Expanded(
                child: Text(
                  schedule.name,
                  // textAlign: TextAlign.center,
                  overflow: TextOverflow.visible,
                  maxLines: 1,
                  style: const TextStyle(
                    color: AppColors.primaryBlack,
                    fontSize: 14,
                    fontFamily: 'SF Pro Display',
                    fontWeight: FontWeight.w700,
                    height: 0.08,
                  ),
                ),
              ),
              const SizedBox(width: 6),
              Row(
                mainAxisSize: MainAxisSize.min,
                mainAxisAlignment: MainAxisAlignment.end,
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  Text(
                    schedule.date,
                    textAlign: TextAlign.right,
                    maxLines: 1,
                    style: const TextStyle(
                      color: AppColors.textGrey500,
                      fontSize: 14,
                      fontFamily: 'SF Pro Display',
                      fontWeight: FontWeight.w700,
                      // height: 0.08,
                    ),
                  ),
                ],
              ),
              const SizedBox(width: 16),
              Container(
                width: 16.w,
                height: 16.w,
                clipBehavior: Clip.antiAlias,
                decoration: const BoxDecoration(),
                child: Icon(Icons.arrow_forward_ios_outlined,
                    size: 16.w, color: AppColors.textGrey500),
              ),
            ],
          ),
        ),
      ),
    );
  }

  void showCustomDialog(BuildContext context, Schedule schedule) {
    showGeneralDialog(
      context: context,
      barrierLabel: "",
      barrierDismissible: true,
      barrierColor: Colors.black.withOpacity(0.5),
      transitionDuration: const Duration(milliseconds: 200),
      pageBuilder: (_, __, ___) {
        return Center(
          child: schedulePopUp(schedule, context),
        );
      },
      transitionBuilder: (_, anim, __, child) {
        Tween<Offset> tween;
        if (anim.status == AnimationStatus.reverse) {
          tween = Tween(begin: const Offset(0, -1), end: Offset.zero);
        } else {
          tween = Tween(begin: const Offset(0, -1), end: Offset.zero);
        }

        return SlideTransition(
          position: tween.animate(anim),
          child: FadeTransition(
            opacity: anim,
            child: child,
          ),
        );
      },
    );
  }

  Widget schedulePopUp(Schedule schedule,BuildContext context){
    return Container(
      width: 335.w,
      padding: EdgeInsets.symmetric(horizontal: 20.w, vertical: 12.h),
      clipBehavior: Clip.antiAlias,
      decoration: ShapeDecoration(
        color: Colors.white,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
      ),
      child: ConstrainedBox(
        constraints: new BoxConstraints(
          minHeight: 160.h,
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          mainAxisAlignment: MainAxisAlignment.start,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const SizedBox(
              width: double.infinity,
              child: Row(
                mainAxisSize: MainAxisSize.min,
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  Expanded(
                    child: SizedBox(
                      child: Text(
                        '決済までの流れ',
                        style: TextStyle(
                          color: AppColors.textDart,
                          fontSize: 14,
                          fontFamily: 'SF Pro Display',
                          fontWeight: FontWeight.w700,
                          decoration: TextDecoration.none,
                          // height: 0.10,
                        ),
                      ),
                    ),
                  ),
                  SizedBox(width: 10),
                  // Container(
                  //   width: 24,
                  //   height: 24,
                  //   padding: const EdgeInsets.all(5),
                  //   child: const Icon(Icons.close, color: AppColors.textGrey, size: 24),
                  // ),
                ],
              ),
            ),
            const SizedBox(height: 24),
            SizedBox(
              width: double.infinity,
              height: 20,
              child: Row(
                mainAxisSize: MainAxisSize.min,
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  Expanded(
                    child: SizedBox(
                      child: Text(
                        schedule.name,
                        style: const TextStyle(
                          color: Color(0xFFB49554),
                          fontSize: 16,
                          fontFamily: 'SF Pro Display',
                          fontWeight: FontWeight.w700,
                          decoration: TextDecoration.none,
                        ),
                      ),
                    ),
                  ),
                  SizedBox(width: 6.w),
                  Row(
                    mainAxisSize: MainAxisSize.min,
                    mainAxisAlignment: MainAxisAlignment.end,
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      Text(
                        schedule.date,
                        textAlign: TextAlign.right,
                        style: const TextStyle(
                          color: Color(0xFFB49554),
                          fontSize: 14,
                          fontFamily: 'SF Pro Display',
                          fontWeight: FontWeight.w700,
                          decoration: TextDecoration.none,
                          // height: 0.08,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
            const SizedBox(height: 6),
            Container(
              width: double.infinity,
              clipBehavior: Clip.antiAlias,
              decoration: const BoxDecoration(),
              child: Row(
                mainAxisSize: MainAxisSize.min,
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Expanded(
                    child: SizedBox(
                      child: Text(
                        schedule.description,
                        style: const TextStyle(
                          color: AppColors.primaryBlack,
                          fontSize: 12,
                          fontFamily: 'SF Pro Display',
                          fontWeight: FontWeight.w400,
                          decoration: TextDecoration.none,
                        ),
                        textAlign: TextAlign.justify,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}