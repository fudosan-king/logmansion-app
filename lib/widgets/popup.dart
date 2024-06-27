import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import './colors.dart';

class CustomDialog {

  static Future<void> alertDialog({
    required BuildContext context,
    String? title,
    String? content,
    String? buttonLabel,
  }) {
    return showDialog<void>(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext context) {
        return Dialog(
          backgroundColor: AppColors.popupColor,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(20),
          ),
          child: Padding(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                if (title != null)
                  Center(
                      child: Padding(
                        padding: const EdgeInsets.only(bottom: 8,),
                        child: SizedBox(
                          width: 238.w,
                          child: Text(
                            title ?? "",
                            textAlign: TextAlign.center,
                            style: const TextStyle(
                              color: AppColors.textDart,
                              fontSize: 18,
                              fontFamily: 'SF Pro Text',
                              fontWeight: FontWeight.w700,
                            ),
                          ),
                        ),
                      ),
                  ),
                if (content != null)
                  Padding(
                    padding: const EdgeInsets.only(bottom: 8,),
                    child: Center(
                        child: SizedBox(
                          width: 210.w,
                          child: Text(
                            content ?? "",
                            textAlign: TextAlign.center,
                            style: const TextStyle(
                              color: Color(0xFF667185),
                              fontSize: 16,
                              fontFamily: 'SF Pro Text',
                              fontWeight: FontWeight.w400,
                            ),
                          ),
                        )
                    ),
                  ),
                const Divider(thickness: 1, color: Colors.grey),
                Center(
                  child: TextButton(
                    child: Text(
                      buttonLabel ?? "OK",
                      textAlign: TextAlign.center,
                      style: const TextStyle(
                        color: Color(0xFF2F80ED),
                        fontSize: 18,
                        fontFamily: 'SF Pro Text',
                        fontWeight: FontWeight.w400,
                      ),
                    ),
                    onPressed: () {
                      Navigator.of(context).pop();
                    },
                  ),
                ),
              ],
            ),
          ),
        );
      },
    );
    return showDialog<void>(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext context) {

        return AlertDialog(
          title: Center(
            child: SizedBox(
              width: 238.w,
              child: Text(
                title ?? "",
                textAlign: TextAlign.center,
                style: const TextStyle(
                  color: AppColors.textDart,
                  fontSize: 18,
                  fontFamily: 'SF Pro Text',
                  fontWeight: FontWeight.w700,
                ),
              ),
          ),
          ),
          content: IntrinsicHeight(
            child: Center(
                child: Column(
                  children: [
                    SizedBox(
                      width: 238.w,
                      child: Text(
                        content ?? "",
                        textAlign: TextAlign.center,
                        style: const TextStyle(
                          color: Color(0xFF667185),
                          fontSize: 16,
                          fontFamily: 'SF Pro Text',
                          fontWeight: FontWeight.w400,
                        ),
                      ),
                    ),
                    const SizedBox(height: 20),
                    const Divider(thickness: 1, color: Colors.grey),
                  ],
                )
            ),
          ),
          backgroundColor: AppColors.popupColor,
          actions: <Widget>[
            Center(
              child: TextButton(
                child: Text(
                  buttonLabel ?? "OK",
                  textAlign: TextAlign.center,
                  style: const TextStyle(
                    color: Color(0xFF2F80ED),
                    fontSize: 18,
                    fontFamily: 'SF Pro Text',
                    fontWeight: FontWeight.w400,
                  ),
                ),
                onPressed: () {
                  Navigator.of(context).pop();
                },
              ),
            ),
          ],
        );
      },
    );
  }


}
