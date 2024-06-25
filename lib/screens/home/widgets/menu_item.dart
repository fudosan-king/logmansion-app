import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import '../../../widgets/colors.dart';

class MenuItem extends StatelessWidget {
  MenuItem({
    super.key,
    required this.title,
    required this.image,
    this.onTap,
  });

  final String title;
  final String image;
  void Function()? onTap;

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: onTap,
      child: Container(
        width: 105.w,
        height: 100.w,
        // padding: const EdgeInsets.only(
        //   top: 15,
        //   left: 34,
        //   right: 34,
        //   bottom: 15,
        // ),
        clipBehavior: Clip.antiAlias,
        decoration: ShapeDecoration(
          color: AppColors.primaryBlack,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            Container(
                width: 50.w,
                height: 50.w,
                // margin: EdgeInsets.only(bottom: 10),
                clipBehavior: Clip.antiAlias,
                decoration: BoxDecoration(),
                child: Image.asset(image)),
            Text(
              title,
              style: TextStyle(
                color: Colors.white,
                fontSize: 13,
                fontFamily: 'SF Pro Display',
                fontWeight: FontWeight.w700,
                // height: 0.15,
              ),
            ),
          ],
        ),
      ),
    );
  }
}